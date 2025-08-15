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
        $nativeLanguage = Language::find($conversation->native_language_id);
        $practisingLanguage = Language::find($conversation->practising_language_id);
        $messages = $this->buildMessages($conversation, $data['prompt'], $practisingLanguage, $nativeLanguage);

        $body = [
                 'model'    => env('AI_MODEL'),
                 'messages' => $messages,
                ];

        $response = Http::timeout(-1)
                        ->withToken(env('GROQ_API_KEY'))
                        ->post("https://api.groq.com/openai/v1/chat/completions", $body);

        $parsed           = $this->formatAiResponse($response);
        $reply       = $parsed['response'];
        $replyTranslation = isset($parsed['translation']) ? $parsed['translation'] : null;
        $replyAudioUri  = $this->synthesizeSpeech($reply, $practisingLanguage);

        $this->saveConversation($data['prompt'], $reply, $id);

        return response()->json([
            'message'     => 'Data received successfully!',
            'response'    => $reply,
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
        $gender = $conversation->practisingLanguage->speech_generator_gender;
        $filename = $gender == 'Female' ? "avatars/lady_avatar.webp" : "avatars/man_avatar.webp";
        $conversation->avatar = Storage::disk('s3')->temporaryUrl(
            $filename,
            now()->addMinutes(5)
        );

        return response()->json($conversation);
    }

    private function buildMessages(Conversation $conversation, string $userPrompt, Language $practisingLanguageRecord, Language $nativeLanguageRecord): array
    {
        $latestMessage = Message::where('conversation_id', $conversation->id)->latest()->first();
        $topic = $conversation->topic->title;
        $inaproppriate = $practisingLanguageRecord->phrases['inappropriate'];
        $mistake = $practisingLanguageRecord->phrases['mistake'];
        $misunderstanding = $practisingLanguageRecord->phrases['missunderstanding'];
        $topicChange = $practisingLanguageRecord->phrases['topic_change'];
        $practisingLanguage = $practisingLanguageRecord->name;
        $nativeLanguage = $nativeLanguageRecord->name;

        $system = <<<EOT
                        You are a friendly {$practisingLanguage}-language tutor bot.
                        Rules:
                        1. Respond only in {$practisingLanguage}.
                        2. Keep your reply short: no more than 15 words.
                        3. Your responses should be strictly at level {$conversation->level}.
                        4. This is the topic of the conversation: {$topic}
                        5. If the user tries to change the topic, always answer this:
                        {$topicChange}
                        6. If the user speaks general, answer but try to return to the topic.
                        7. If the user's request is abusive, sexual, illegal, or inappropriate, respond exactly:
                        {$inaproppriate}
                        8. Always return your reply in this exact JSON format (no extra text, no markdown):
                        {
                        "response": "<your {$practisingLanguage} reply>",
                        "translation": "<Translation in {$nativeLanguage} language of your {$practisingLanguage} reply>"
                        }
                        9. If the latest message contains any grammar or syntax mistakes, point them out and provide 
                          corrections. Ignore typos, misspellings, punctuation errors or even missing questionmarks
                          (you can understand if it is question or not).
                           reply in this exact JSON format (no extra text, no markdown):
                        {
                        "response": "{$mistake}... <corrected phrase or suggestion in {$practisingLanguage} language>?"
                        }
                        10. If you just didn't understand what the user means reply in this exact JSON format (no extra text, no markdown):
                        {
                        "response": {$misunderstanding}
                        }
                    EOT;

        $system .= $this->attachConversationHistory($conversation);

        return [
                ['role'    => 'system',  'content' => trim($system)],
                ['role'    => 'user',    'content' => $userPrompt],
               ];
    }

    private function attachConversationHistory(Conversation $conversation): string
    {
        $historyString = '';
        $history = Message::where('conversation_id', $conversation->id)
                        ->oldest()
                        ->take(6)
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

    private function formatAiResponse(ApiResponse $response): array
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

    public function synthesizeSpeech(string $text, Language $practisingLanguage): ?string
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
            'Engine'       => $practisingLanguage->speech_generator_engine,
            'Text'         => $text,
            'OutputFormat' => 'mp3',
            'LanguageCode' => $practisingLanguage->speech_generator_language_code,
            'VoiceId'      => $practisingLanguage->speech_generator_voice_id,
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
