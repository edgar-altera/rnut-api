<?php

namespace App\Http\Resources;

use App\Models\Owner;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerVehiclesResource extends JsonResource
{
    public function __construct(
        protected Owner $owner,
        protected $vehicles
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
         return [
            'owner' => new OwnerResource($this->owner),

            'vehicles' => VehicleResource::collection(
                $this->vehicles->items()
            ),

            'pagination' => [
                'current_page' => $this->vehicles->currentPage(),
                'per_page'     => $this->vehicles->perPage(),
                'next_page'    => $this->vehicles->nextPageUrl(),
            ],
        ];
    }
}
