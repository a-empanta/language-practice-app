<?php

namespace App\Enums;

enum TranscriberAIModels: string
{
    case ENGLISH_US = "vosk-model-en-us-0.42-gigaspeech";
    case INDIAN_ENGLISH = "vosk-model-en-in-0.5";
    case CHINESE_MANDARIN = "vosk-model-cn-0.22";
    case RUSSIAN = "vosk-model-ru-0.42";
    case FRENCH = "vosk-model-fr-0.22";
    case GERMAN = "vosk-model-de-tuda-0.6-900k";
    case SPANISH = "vosk-model-es-0.42";
    case PORTUGUESE = "vosk-model-pt-fb-v0.1.1-20220516_2113";
    case TURKISH = "vosk-model-small-tr-0.3";
    case ITALIAN = "vosk-model-it-0.22";
    case DUTCH = "vosk-model-nl-spraakherkenning-0.6";
    case CATALAN = "vosk-model-small-ca-0.4";
    case ARABIC = "vosk-model-ar-mgb2-0.4";
    case SWEDISH = "vosk-model-small-sv-rhasspy-0.15";
    case JAPANESE = "vosk-model-ja-0.22";
    case HINDI = "vosk-model-hi-0.22";
    case CZECH = "vosk-model-small-cs-0.4-rhasspy";
    case POLISH = "vosk-model-small-pl-0.22";
    case KOREAN = "vosk-model-small-ko-0.22";

    public static function all(): array
    {
        return array_map(fn($level) => $level->value, self::cases());
    }
}
