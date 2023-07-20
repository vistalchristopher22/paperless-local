<?php

namespace App\Enums;

enum LegislateType: string
{
    case RESOLUTION = 'resolution';
    case ORDINANCE = 'ordinance';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }


    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }


}
