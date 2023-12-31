<?php

namespace App\Http\Controllers\Api;

use App\Enums\SenderType;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Language;
use App\Models\Conversation;
use Aws\Polly\PollyClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response as ApiResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class ConversationController extends Controller
{
    public function reply(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'prompt' => 'required|string',
        ]);
        $conversation = Conversation::find($id);
        $nativeLanguage = Language::find($conversation->native_language_id)->name;
        $practisingLanguage = Language::find($conversation->practising_language_id)->name;
        $messages = $this->buildMessages($id, $data['prompt'], $practisingLanguage, $nativeLanguage);

        $body = [
                 'model'    => env('AI_MODEL'),
                 'messages' => $messages,
                ];

        $response = Http::timeout(-1)
                        ->withToken(env('GROQ_API_KEY'))
                        ->post("https://api.groq.com/openai/v1/chat/completions", $body);

        $parsed           = $this->formatAiResponse($response, $nativeLanguage);
        $replyDutch       = $parsed['response'];
        $replyTranslation = isset($parsed['translation']) ? $parsed['translation'] : null;
        $replyAudioUri  = $this->synthesizeSpeech($replyDutch);

        $this->saveConversation($data['prompt'], $replyDutch, $id);

        return response()->json([
            'message'     => 'Data received successfully!',
            'response'    => $replyDutch,
            'translation' => $replyTranslation,
            'replyAudioUri' => $replyAudioUri,
        ]);
    }

    public function getLatestConversation(Request $request): JsonResponse
    {
        $latest = auth()->user()->conversations()->latest()->first();
        

        return response()->json([
            'conversationId' => $latest ? $latest->id : null,
        ]);
    }

    public function newConversation(Request $request): JsonResponse
    {        
        $data = $request->validate([
            'practiseLanguageId' => 'required|integer|exists:languages,id',
            'translatingLanguageId' => 'required|integer|exists:languages,id',
            'categoryId' => 'required|integer|exists:topic_categories,id',
            'topicId' => 'required|integer|exists:topics,id',
            'level' => 'required|string|max:255',
        ]);

        $conversation = auth()->user()->conversations()->create(
            [
                'topic_id' => $request['topicId'],
                'level'    => $request['level'],
                'native_language_id'  => $request['translatingLanguageId'],
                'practising_language_id' => $request['practiseLanguageId'],
            ]
        );
                
        return response()->json([
            'message'        => 'Conversation created successfully',
            'conversationId' => $conversation->id,
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $conversation = auth()->user()->conversations()
                        ->with(['nativeLanguage', 'practisingLanguage', 'topic'])
                        ->findOrFail($id);

        return response()->json($conversation);
    }

    private function buildMessages(int $conversationId, string $userPrompt, string $practisingLanguage, string $nativeLanguage): array
    {
        $conversation = Conversation::find($conversationId);
        $topic = $conversation->topic->title;
        $latestMessage = Message::where('conversation_id', $conversationId)
                                ->latest()
                                ->first();
        $practisingLanguageRecord = Language::where('name', $practisingLanguage)->first();
        $inaproppriate = $practisingLanguageRecord->phrases['inappropriate'];
        $mistake = $practisingLanguageRecord->phrases['mistake'];
        $misunderstanding = $practisingLanguageRecord->phrases['missunderstanding'];
        $topicChange = $practisingLanguageRecord->phrases['topic_change'];

        $system = <<<EOT
                        You are a friendly {$practisingLanguage}-language tutor bot.
                        Rules:
                        1. Respond only in {$practisingLanguage}.
                        2. Keep your reply short: no more than 15 words.
                        3. Your responses should be strictly at level {$conversation->level}.
                        6. If the user tries to change the topic, always answer this:
                        {$topicChange}
                        3. If the user's request is abusive, sexual, illegal, or inappropriate, respond exactly:
                        {$inaproppriate}
                        4. Always return your reply in this exact JSON format (no extra text, no markdown):

                        {
                        "response": "<your {$practisingLanguage} reply>",
                        "translation": "<Translation in {$nativeLanguage} language of your {$practisingLanguage} reply>"
                        }
                        5. If the latest message has any vocabulary, grammar, syntax, or any kind of mistakes,
                           reply in this exact JSON format (no extra text, no markdown):
                        {
                        "response": "{$mistake} <corrected phrase or suggestion in {$practisingLanguage} language>?"
                        }
                        6. If you just didn't understand what the user means reply in this exact JSON format (no extra text, no markdown):
                        {
                        "response": {$misunderstanding}
                        }
                    EOT;

        $system .= $this->attachConversationHistory($conversationId);

        return [
                ['role'    => 'system',  'content' => trim($system)],
                ['role'    => 'user',    'content' => $userPrompt],
               ];
    }

    private function attachConversationHistory(int $conversationId): string
    {
        $historyString = '';

        $history = Message::where('conversation_id', $conversationId)
                        ->oldest()
                        ->take(4)
                        ->get();

        if ($history->isNotEmpty()) {
            $historyString .= 'Here are the latest messages that you exchanged with this user:\n';

            foreach ($history as $msg) {
                $sender = $msg->sender_type === SenderType::USER ? 'user' : 'assistant';
                $historyString .= "\n$sender: " . $msg->message;
            }
        }

        return $historyString;
    }

    private function formatAiResponse(ApiResponse $response, string $nativeLanguage): array
    {
        $default = [
            'response' => 'I am sorry, but I do not understand what you mean. Could you repeat that?'
        ];

        $json = $response->json();

        if (empty($json['choices'][0]['message']['content'])) {
            return $default;
        }

        if(isset($json['choices'])) {
            $parsed = $response->json()['choices'][0]['message']['content'];

            // We remove the thinking part of the model if exists:
            if (strpos($parsed, '</think>') !== false) {
                $parsed = explode('</think>', $parsed)[1];
            }
        }
        
        $decodedResponse = json_decode($parsed, true);
        $response = ['response' => $decodedResponse['response']];

        if(isset($decodedResponse['translation'])) {
            $response['translation'] = $decodedResponse['translation'];
        }

        return $response;
    }

    public function synthesizeSpeech(string $text): ?string
    {
        $polly = new PollyClient([
            'region'      => config('services.aws.region'),
            'version'     => 'latest',
            'credentials' => [
                'key'    => config('services.aws.key'),
                'secret' => config('services.aws.secret'),
            ],
        ]);

        $result = $polly->synthesizeSpeech([
            'Engine'       => 'neural',
            'Text'         => $text,
            'OutputFormat' => 'mp3',
            'LanguageCode' => 'nl-NL',
            'VoiceId'      => 'Laura',
        ]);

        // Choose a filename (under a per-user folder if you like)
        $userId   = auth()->id();
        $filename = "user-{$userId}/voice-".uniqid().".mp3";

        // Clear the user's s3 folder since we save only the latest response
        Storage::disk('s3')->deleteDirectory("user-{$userId}");

        // 3) Upload privately (no 'public' flag → private by default)
        Storage::disk('s3')->put($filename, $result['AudioStream']);

        $bytes = Storage::disk('s3')->get($filename);

        // optionally clean up old files…
        Storage::disk('s3')->deleteDirectory("user-{$userId}");

        // return a data URI
        return 'data:audio/mpeg;base64,' . base64_encode($bytes);
    }

    private function saveConversation(string $prompt, string $answer, int $conversation_id): void
    {
        Message::create([
            'message'         => $prompt,
            'sender_type'     => SenderType::USER,
            'conversation_id' => $conversation_id,
        ]);

        Message::create([
            'message'         => $answer,
            'sender_type'     => SenderType::AI,
            'conversation_id' => $conversation_id,
        ]);
    }
}
