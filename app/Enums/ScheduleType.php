<?php

namespace App\Enums;

enum ScheduleType: string
{
    case MEETING = 'committee';
    case SESSION = 'session';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
