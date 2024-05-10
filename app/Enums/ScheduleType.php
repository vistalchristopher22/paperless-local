<?php

namespace App\Enums;

enum ScheduleType: string
{
    case SESSION = 'Regular Session';
    case JOINT_SESSION = 'Joint Session';
    case SPECIAL_SESSION = 'Special Session';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
