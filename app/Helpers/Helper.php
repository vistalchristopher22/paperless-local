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
