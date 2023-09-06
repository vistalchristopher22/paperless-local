<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckFilename implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $FILENAME_PATTERN = '/^[A-Za-z0-9_]+(\.[A-Za-z0-9]+)?$/';
        $fileName = $value->getClientOriginalName();

        if (!preg_match($FILENAME_PATTERN, $fileName)) {
            $fail('Only alphanumeric characters and underscores are allowed e.g.');
        }
    }
}
