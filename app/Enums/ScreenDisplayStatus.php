<?php

namespace App\Enums;

enum ScreenDisplayStatus: string
{
    case ON_GOING = 'on_going';
    case NEXT = 'next';
    case PENDING = 'pending';
    case DONE = 'done';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
