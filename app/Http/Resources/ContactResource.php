<?php

namespace App\Http\Resources;

use App\Models\ContactType;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $type = ContactType::cached()->get($this->tipo);

        return [
            'type'  => $type?->descripcion,
            'value' => $this->dato,
        ];
    }
}
