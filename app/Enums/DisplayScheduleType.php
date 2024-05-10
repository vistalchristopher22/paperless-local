<?php

namespace App\Enums;

enum DisplayScheduleType: string
{
  case MEETING = 'Meeting';
  case ORDER_OF_BUSINESS = 'Session';

  public static function values(): array
  {
    return array_column(self::cases(), 'value');
  }

  public static function names(): array
  {
    return array_column(self::cases(), 'name');
  }
}
