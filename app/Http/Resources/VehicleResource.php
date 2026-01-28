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
            'license_plate' => $this->patente,
            'dv' => $this->dv,
            'brand' => $this->marca,
            'model' => $this->modelo,
            'year' => $this->ano,
            'version' => $this->version,
            'color' => $this->color,
            'urbanCategory' => $this->whenLoaded(
                'urbanCategory',
                fn () => $this->urbanCategory->descripcion
            ),
            'interurbanCategory' => $this->whenLoaded(
                'interurbanCategory',
                fn () => $this->interurbanCategory->descripcion
            ),
        ];
    }
}
