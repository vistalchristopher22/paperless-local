<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use App\Utilities\StringUtility;
use Illuminate\Support\Str;

final class BoardSessionDocumentService
{
    // The text segment that identifies the start of a document reading.
    public const DOCUMENT_HEADER_TEXT_SEGMENT = "Call to Order";

    /**
     * Returns an array of document readings and their data.
     *
     * @param string $data - the document data to search for readings
     * @return array - an array of document readings and their data
     */
    public function getDocumentReadings(string $data): array
    {
        $firstReadingData = $this->getReadingData('first_Reading', $data);
        $secondReadingData = $this->getReadingData('second_reading', $data);
        $thirdReadingData = $this->getReadingData('third_reading', $data);

        return [
            'firstReading' => [
                'has_data' => $this->hasReading($firstReadingData),
                'data' => $this->hasReading($firstReadingData) ? $this->createReadingData($firstReadingData) : "",
            ],
            'secondReading' => [
                'has_data' => $this->hasReading($secondReadingData),
                'data' => $this->createReadingData($secondReadingData),
            ],
            'thirdReading' => [
                'has_data' => $this->hasReading($thirdReadingData),
                'data' => $this->hasReading($thirdReadingData) ? $this->createReadingData($thirdReadingData) : "",
            ],
        ];
    }

    /**
     * Returns the data for the specified reading from the document data.
     *
     * @param string $readingName - the name of the reading setting
     * @param string $data - the document data to search for the reading
     * @return string - the data for the specified reading
     *
     * I declare new utility for getting the string between start and end delimiter
     * Str::between of laravel works, but it doesn't get the last word of the string
     * Which sometimes get or output a incomplete string
     */
    private function getReadingData(string $readingName, string $data): string
    {
        $startMarker = SettingRepository::getValueByName($readingName);
        $readingData = StringUtility::getStringBetweenDelimiters(string: $data, startDelimiter: $startMarker, endDelimiter: "$" . $startMarker);
        $readingData = ltrim(trim(preg_replace("/\n+|\t/", "\n", $readingData)));
        return mb_convert_encoding($readingData, 'UTF-8', 'Windows-1252');
    }

    /**
     * Returns true if the reading data contains the document header text segment, indicating that it is not a valid reading.
     *
     * @param string $readingData - the data for the reading
     * @return bool - true if the reading is valid, false otherwise
     */
    private function hasReading(string $readingData): bool
    {
        return !Str::contains(trim($readingData), self::DOCUMENT_HEADER_TEXT_SEGMENT);
    }

    private function createReadingData(string $data): array
    {
        $items = preg_split(pattern: "/\r?\n/", subject: $data);
        return array_values(array_filter(array_map('ltrim', $items)));
    }


    public function readingHasCommittees(array $data): array
    {
        $digitPattern = '/^(\d+\.)\s+/';
        return array_filter(array: array_map(callback: function ($text) use ($digitPattern) {
            if (startsWithDigit($text)) {
                // Split the text using the regex pattern as the delimiter and capture the delimiter
                $pieces = array_values(array_filter(preg_split($digitPattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE)));

                [$number, $paragraph] = $pieces;

                return [
                    'item_no' => (int) $number,
                    'paragraph' => $paragraph,
                ];
            }
        }, array: $data));
    }
}
