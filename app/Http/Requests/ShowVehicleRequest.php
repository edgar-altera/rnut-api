<?php

namespace App\Http\Requests;

use App\Rules\ChileanPlateRule;
use Illuminate\Foundation\Http\FormRequest;

class ShowVehicleRequest extends FormRequest
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
            'licensePlate' => [
                'required',
                'string',
                new ChileanPlateRule()
            ],
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
        if ($this->route('licensePlate')) {
            $this->merge([
                'licensePlate' => strtoupper(
                    $this->route('licensePlate')
                ),
            ]);
        }
    }
}
