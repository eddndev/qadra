<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use PhpCfdi\Rfc\Rfc;
use PhpCfdi\Rfc\Exceptions\InvalidExpressionToParseException;

class ValidRfc implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            Rfc::parse($value);
        } catch (InvalidExpressionToParseException $e) {
            $fail('El :attribute no es un RFC válido de México.');
        }
    }
}
