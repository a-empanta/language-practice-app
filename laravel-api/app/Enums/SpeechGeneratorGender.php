<?php

namespace App\Enums;

enum SpeechGeneratorGender: string
{
    case MALE = 'Male';
    case FEMALE = 'Female';

    public static function all(): array
    {
        return array_map(fn($level) => $level->value, self::cases());
    }
}
