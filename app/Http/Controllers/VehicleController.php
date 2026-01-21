<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowVehicleRequest;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\VehicleResource;
use App\Models\Owner;
use App\Models\Vehicle;
use App\Models\ContractVehicle;
use App\Support\ApiResponse;

class VehicleController extends Controller
{
    public function show(ShowVehicleRequest $request, string $licensePlate)
    {
        $vehicle = Vehicle::with(['owner.contacts.type'])
                        ->where('patente', $licensePlate)
                        ->firstOrFail();

        return ApiResponse::success(data: new VehicleResource($vehicle));
    }

    public function byRut(string $rut)
    {
        $owner = Owner::with(['contacts.type'])
            ->where('rut', $rut)
            ->firstOrFail();

        $vehicles = Vehicle::whereHas('owner', function ($q) use ($rut) {
            $q->where('rut', $rut);
        })->simplePaginate(10);

        return ApiResponse::success(data: [
            'owner'    => new OwnerResource($owner),
            'vehicles' => VehicleResource::collection($vehicles),
        ]);
    }
}
