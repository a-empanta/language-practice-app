<?php

namespace App\Enums;

enum SpeechGeneratorEngine: string
{
    case STANDARD = 'standard';
    case NEURAL = 'neural';

    public static function all(): array
    {
        return array_map(fn($level) => $level->value, self::cases());
    }
}
