<?php

namespace App\Http\Requests;

use App\Rules\ChileanRut;
use Illuminate\Foundation\Http\FormRequest;

class IndexVehiclesByRutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'rut_input' => [
                'required',
                'string',
                new ChileanRut,
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'rut_input' => 'rut',
        ];
    }

    public function validationData(): array
    {
        return array_merge(
            $this->all(),
            $this->route()?->parameters() ?? []
        );
    }

    protected function prepareForValidation(): void
    {
        $rut_input = $this->route('rut');

        if (!$rut_input) {
            return;
        }

        $clean = preg_replace('/[^0-9K]/i', '',  strtoupper($rut_input));

        $body = substr($clean, 0, -1);

        $dv   = substr($clean, -1);

        $this->merge([
            'rut_input' => $rut_input,
            'rut'       => (int) $body,
            'dv'        => $dv,
        ]);
    }
}
