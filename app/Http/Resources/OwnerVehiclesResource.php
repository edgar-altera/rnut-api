<?php

namespace App\Http\Resources;

use App\Models\Owner;
use Illuminate\Http\Resources\Json\JsonResource;

class OwnerVehiclesResource extends JsonResource
{
    public function __construct(
        protected $vehicles,
        protected Owner $owner,
        protected $contacts,
        protected $addresses
    ) {}

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
         return [
            'vehicles' => VehicleResource::collection(
                $this->vehicles->items()
            ),

            'owner' => new OwnerResource($this->owner),

            'contacts' => ContactResource::collection($this->contacts),

            'addresses' => AddressResource::collection($this->addresses),

            'pagination' => [
                'current_page' => $this->vehicles->currentPage(),
                'per_page'     => $this->vehicles->perPage(),
                'next_page'    => $this->vehicles->nextPageUrl(),
            ],
        ];
    }
}
