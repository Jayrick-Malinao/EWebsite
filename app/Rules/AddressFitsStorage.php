<?php

namespace App\Rules;

use App\Support\BarangayAddress;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class AddressFitsStorage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || ! BarangayAddress::fitsStorage($value)) {
            $fail('The selected Purok and locality exceed the address storage limit.');
        }
    }
}
