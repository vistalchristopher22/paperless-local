<?php

namespace App\Enums;

enum UserTypes: string
{
    case ADMIN = 'ADMINISTRATOR';
    case USER = 'NORMAL USER';
    case SP_MEMBER = 'SP MEMBER';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
