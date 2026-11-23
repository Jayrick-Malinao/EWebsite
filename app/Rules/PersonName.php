<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PersonName implements ValidationRule
{
    public function __construct(private bool $allowApostrophes = true) {}

    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (
            ! is_string($value)
            || preg_match(
                $this->allowApostrophes
                    ? '/\A[\p{L}]+(?:[ \'\x{2019}-][\p{L}]+)*\z/u'
                    : '/\A[\p{L}]+(?:[ -][\p{L}]+)*\z/u',
                $value
            ) !== 1
        ) {
            $fail($this->allowApostrophes
                ? 'The :attribute may contain letters, spaces, hyphens, and apostrophes only.'
                : 'The :attribute may contain letters, spaces, and hyphens only.');
        }
    }
}
