<?php

namespace App\Enums;

enum CommitteeStatus: string
{
    case RETURN = 'returned';
    case REVIEW = 'review';
    case APPROVED = 'approved';
    case LOCKED = 'locked';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
