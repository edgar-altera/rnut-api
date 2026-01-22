<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'municipality'  => $this->comuna,
            'street' => $this->calle,
            'number' => $this->numero,
            'aparment' => $this->departamento,
            'postalCode' => $this->codigo_postal,
            'comment' => $this->comentario,
        ];
    }
}
