<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'rut' => $this->rut,
            'dv' => $this->dv,
            'names' => $this->nombres,
            'lastName' => $this->apellido_paterno,
            'secondLastName' => $this->apellido_materno,
            'address' => $this->whenLoaded(
                'address',
                fn () => new AddressResource($this->address)
            ),
        ];
    }
}
