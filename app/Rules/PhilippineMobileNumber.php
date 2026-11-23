<?php

namespace App\Rules;

use App\Support\PhilippineMobileNumberFormatter;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhilippineMobileNumber implements ValidationRule
{
    public function __construct(private ?Request $localInputRequest = null) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $original = $this->localInputRequest
            ? data_get($this->localInputRequest->attributes->get('original_mobile_inputs', []), $attribute)
            : null;

        if (
            ! is_string($value)
            || ! PhilippineMobileNumberFormatter::isValid($value)
            || ($this->localInputRequest && (
                ! is_string($original)
                || preg_match('/\A09\d{2}-?\d{4}-?\d{3}\z/', trim($original)) !== 1
            ))
        ) {
            $fail('The :attribute must have 11 digits and start with 09 (for example, 0918-7111-344).');
        }
    }
}
