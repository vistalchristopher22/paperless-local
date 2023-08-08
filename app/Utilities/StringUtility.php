<?php

namespace App\Utilities;

final class StringUtility
{
    /**
     * Retrieves the substring between two delimiters.
     *
     * @param string $string - The input string to search within.
     * @param string $startDelimiter - The starting delimiter.
     * @param string $endDelimiter - The ending delimiter.
     * @return string|null - The substring between the delimiters, or null if the delimiters are not found.
     */
    public static function getStringBetweenDelimiters(string $string, string $startDelimiter, string $endDelimiter): ?string
    {
        $startPosition = strpos($string, $startDelimiter);
        if ($startPosition === false) {
            return null;
        }

        $startPosition += strlen($startDelimiter);
        $endPosition = strpos($string, $endDelimiter, $startPosition);
        if ($endPosition === false) {
            return null;
        }

        return substr($string, $startPosition, $endPosition - $startPosition);
    }
}
