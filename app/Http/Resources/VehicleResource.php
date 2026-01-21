<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'vehicle' => [
                'license_plate' => $this->patente,
                'dv' => $this->dv,
                'brand' => $this->marca,
                'model' => $this->modelo,
                'year' => $this->ano,
                'version' => $this->version,
                'color' => $this->color,
            ],
            'owner' => new OwnerResource($this->owner)
        ];
    }
}
