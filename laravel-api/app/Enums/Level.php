<?php

namespace App\Enums;

enum Level: string
{
    case BEGINNER_A1 = 'Beginner (A1)';
    case ELEMENTARY_A2 = 'Elementary (A2)';
    case INTERMEDIATE_B1 = 'Intermediate (B1)';
    case UPPER_INTERMEDIATE_B2 = 'Upper Intermediate (B2)';
    case ADVANCED_C1 = 'Advanced (C1)';
    case PROFICIENT_C2 = 'Proficient (C2)';

    public static function all(): array
    {
        return array_map(fn($level) => $level->value, self::cases());
    }
}
