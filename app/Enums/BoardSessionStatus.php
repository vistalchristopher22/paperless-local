<?php

namespace App\Enums;

enum BoardSessionStatus: string
{
    case LOCKED = 'LOCKED';
    case UNLOCKED = '';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
