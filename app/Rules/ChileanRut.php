<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ChileanRut implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $rut = strtoupper(preg_replace('/[^0-9Kk]/', '', $value));

        if (strlen($rut) < 2) {

            $fail(__('validation.chilean_rut'));

            return;
        }

        $body = substr($rut, 0, -1);

        $dv   = substr($rut, -1);

        if (!ctype_digit($body)) {

            $fail(__('validation.chilean_rut'));

            return;
        }

        if ($this->calculateDv($body) !== $dv) {

            $fail(__('validation.chilean_rut'));
        }
    }

    private function calculateDv(string $rut): string
    {
        $sum = 0;

        $multiplier = 2;

        for ($i = strlen($rut) - 1; $i >= 0; $i--) {

            $sum += $rut[$i] * $multiplier;
            
            $multiplier = $multiplier == 7 ? 2 : $multiplier + 1;
        }

        $rest = 11 - ($sum % 11);

        return match ($rest) {
            11 => '0',
            10 => 'K',
            default => (string) $rest,
        };
    }
}
