<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ChileanPlateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $plate = strtoupper(trim($value));

        $letter = '[A-HJ-NPR-Z]'; // Excluded I, O, Q

        $patterns = [
            "/^{$letter}{2}[0-9]{4}$/",     // LLNNNN
            "/^{$letter}{3}[0-9]{3}$/",     // LLLNNN
            "/^{$letter}{4}[0-9]{2}$/",     // LLLLNN
            // "/^(ARMY|FACH|NAVY)[0-9]{3}$/", // FF.AA
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $plate)) {
                return;
            }
        }

        $fail($attribute, __('validation.chilean_plate'));
    }
}
