<?php

namespace App\Enums;

enum SenderType: string
{
    case USER = 'user';
    case AI = 'ai';

    public static function all(): array
    {
        return array_map(fn($level) => $level->value, self::cases());
    }
}
