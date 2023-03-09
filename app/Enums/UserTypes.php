<?php

namespace App\Enums;

enum UserTypes
{
    case ADMIN;
    case USER;

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
