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


function removeTimestampPrefix($file_name)
{
    $underscore_pos = strpos($file_name, '_');

    if ($underscore_pos !== false) {
        $file_name = substr($file_name, $underscore_pos + 1);
    }

    return $file_name;
}


function removeFileExtension($file_name)
{
    $extension_pos = strrpos($file_name, '.');

    if ($extension_pos !== false) {
        $file_name = substr($file_name, 0, $extension_pos);
    }

    return $file_name;
}

function getIconByFileName(string $fileName): string
{
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    return match ($extension) {
        'pdf' => asset('/assets-2/images/widgets/pdf-icon.svg'),
        'docx' => asset('/assets-2/images/widgets/word-icon.svg'),
        'doc' => asset('/assets-2/images/widgets/word-icon.svg'),
        'xlsx' => asset('/assets-2/images/widgets/google-sheets-icon.svg'),
        'pptx' => asset('/assets-2/images/widgets/google-slides-icon.svg'),
        default => asset('/assets-2/images/widgets/image-placeholder.svg'),
    };
}


function generateHTMLSpace(int $times): string
{
    return str_repeat("&nbsp;", $times);
}
