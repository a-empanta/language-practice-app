<?php

namespace Database\Seeders;

use App\Enums\SpeechGeneratorEngine;
use App\Enums\SpeechGeneratorGender;
use App\Enums\TranscriberAIModels;
use App\Models\Language;
use Illuminate\Database\Seeder;
use App\Enums\ReusablePhrases;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(Language::count() > 0) {
            return;
        }

        $languages = [
            [
                'name'                             => 'Arabic',
                'speech_generator_engine'          => SpeechGeneratorEngine::STANDARD,
                'transcriber_ai_model'             => TranscriberAIModels::ARABIC,
                'speech_generator_language_code'   => 'arb',
                'speech_generator_voice_id'        => 'Zeina',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::ARABIC->allTranslations(),
            ],
            [
                'name'                             => 'Arabic (Gulf)',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::ARABIC,
                'speech_generator_language_code'   => 'ar-AE',
                'speech_generator_voice_id'        => 'Hala',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::ARABIC->allTranslations(),
            ],
            [
                'name'                             => 'Catalan',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::CATALAN,
                'speech_generator_language_code'   => 'ca-ES',
                'speech_generator_voice_id'        => 'Arlet',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::CATALAN->allTranslations(),                
            ],
            [
                'name'                             => 'Chinese (Mandarin)',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::CHINESE_MANDARIN,
                'speech_generator_language_code'   => 'cmn-CN',
                'speech_generator_voice_id'        => 'Zhiyu',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::CHINESE_MANDARIN->allTranslations(),            
            ],
            [
                'name'                             => 'Czech',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::CZECH,
                'speech_generator_language_code'   => 'cs-CZ',
                'speech_generator_voice_id'        => 'Jitka',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::CZECH->allTranslations(),         
            ],
            [
                'name'                             => 'Dutch',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::DUTCH,
                'speech_generator_language_code'   => 'nl-NL',
                'speech_generator_voice_id'        => 'Laura',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::DUTCH->allTranslations(),               
            ],
            [
                'name'                             => 'English (US)',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::ENGLISH_US,
                'speech_generator_language_code'   => 'en-US',
                'speech_generator_voice_id'        => 'Danielle',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::ENGLISH_US->allTranslations(),               
            ],
            [
                'name'                             => 'French',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::FRENCH,
                'speech_generator_language_code'   => 'fr-FR',
                'speech_generator_voice_id'        => 'Léa',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::FRENCH->allTranslations(),           
            ],
            [
                'name'                             => 'Hindi',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::HINDI,
                'speech_generator_language_code'   => 'hi-IN',
                'speech_generator_voice_id'        => 'Kajal',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::HINDI->allTranslations(),              
            ],
            [
                'name'                             => 'German',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::GERMAN,
                'speech_generator_language_code'   => 'de-DE',
                'speech_generator_voice_id'        => 'Vicki',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::GERMAN->allTranslations(),         
            ],
            [
                'name'                             => 'Italian',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::ITALIAN,
                'speech_generator_language_code'   => 'it-IT',
                'speech_generator_voice_id'        => 'Bianca',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::ITALIAN->allTranslations(),         
            ],
            [
                'name'                             => 'Japanese',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::JAPANESE,
                'speech_generator_language_code'   => 'ja-JP',
                'speech_generator_voice_id'        => 'Kazuha',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::JAPANESE->allTranslations(),              
            ],
            [
                'name'                             => 'Polish',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::POLISH,
                'speech_generator_language_code'   => 'pl-PL',
                'speech_generator_voice_id'        => 'Ola',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::POLISH->allTranslations(),          
            ],
            [
                'name'                             => 'Portuguese (Brazilian)',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::PORTUGUESE,
                'speech_generator_language_code'   => 'pt-BR',
                'speech_generator_voice_id'        => 'Vitória/Vitoria',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::PORTUGUESE->allTranslations(),       
            ],
            [
                'name'                             => 'Portuguese (European)',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::PORTUGUESE,
                'speech_generator_language_code'   => 'pt-PT',
                'speech_generator_voice_id'        => 'Inês/Ines',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::PORTUGUESE->allTranslations(),          
            ],
            [
                'name'                             => 'Russian',
                'speech_generator_engine'          => SpeechGeneratorEngine::STANDARD,
                'transcriber_ai_model'             => TranscriberAIModels::RUSSIAN,
                'speech_generator_language_code'   => 'ru-RU',
                'speech_generator_voice_id'        => 'Tatyana',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::RUSSIAN->allTranslations(),             
            ],
            [
                'name'                             => 'Spanish (Spain)',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::SPANISH,
                'speech_generator_language_code'   => 'es-ES',
                'speech_generator_voice_id'        => 'Alba',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::SPANISH->allTranslations(),        
            ],
            [
                'name'                             => 'Turkish',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::TURKISH,
                'speech_generator_language_code'   => 'tr-TR',
                'speech_generator_voice_id'        => 'Burcu',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::TURKISH->allTranslations(),             
            ],
            [
                'name'                             => 'Swedish',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::SWEDISH,
                'speech_generator_language_code'   => 'sv-SE',
                'speech_generator_voice_id'        => 'Elin',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::SWEDISH->allTranslations(),              
            ],
            [
                'name'                             => 'Korean',
                'speech_generator_engine'          => SpeechGeneratorEngine::NEURAL,
                'transcriber_ai_model'             => TranscriberAIModels::KOREAN,
                'speech_generator_language_code'   => 'ko-KR',
                'speech_generator_voice_id'        => 'Seoyeon',
                'speech_generator_gender'          => SpeechGeneratorGender::FEMALE,
                'phrases'                          => ReusablePhrases::KOREAN->allTranslations(),           
            ],
        ];

        Language::insert($languages);
    }
}
