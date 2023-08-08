<?php


function addNumberSuffix($num): string
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

function formatSizeUnits($bytes): string
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

function startsWithDigit($data): bool
{
    return preg_match('/^\d{1,2}\.\s/', $data);
}
