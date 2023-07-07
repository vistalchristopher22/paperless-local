<?php

function addNumberSuffix($num)
{
    if ($num % 100 >= 11 && $num % 100 <= 13) {
        return $num . 'th';
    } else {
        $lastDigit = $num % 10;

        return match ($lastDigit) {
            1 => $num . 'st',
            2 => $num . 'nd',
            3 => $num . 'rd',
            default => $num . 'th',
        };
    }
}

function formatSizeUnits($bytes)
{
    $units = ['bytes', 'KB', 'MB', 'GB', 'TB'];

    if ($bytes == 0) {
        return '0 bytes';
    }

    $i = (int)floor(log($bytes, 1024));
    $size = number_format($bytes / (1024 ** $i), 2);
    $unit = $units[$i];

    return $size . ' ' . $unit;
}
