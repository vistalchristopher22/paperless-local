<?php

namespace App\Enums;

enum SessionDocumentReadingType: string
{
    case FIRST_READING = 'first_reading';
    case SECOND_READING = 'second_reading';
    case THIRD_READING = 'third_reading';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
