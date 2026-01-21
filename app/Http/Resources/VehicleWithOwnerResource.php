<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VehicleWithOwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'vehicle'  => new VehicleResource($this),
            'owner'    => new OwnerResource($this->owner),
            'contacts' => ContactResource::collection(
                $this->owner->contacts
            ),
        ];
    }
}
