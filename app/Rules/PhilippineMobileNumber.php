<?php

namespace App\Rules;

use App\Support\PhilippineMobileNumberFormatter;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhilippineMobileNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            ! is_string($value)
            || ! PhilippineMobileNumberFormatter::isValid($value)
        ) {
            $fail('The :attribute must be a Philippine mobile number in the format 639171234567.');
        }
    }
}
