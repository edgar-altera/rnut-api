<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowVehicleRequest;
use App\Http\Resources\OwnerVehiclesResource;
use App\Http\Resources\VehicleWithOwnerResource;
use App\Models\Owner;
use App\Models\Vehicle;
use App\Support\ApiResponse;

class VehicleController extends Controller
{
    public function show(ShowVehicleRequest $request, string $licensePlate)
    {
        $vehicle = Vehicle::with(['owner.contacts.type'])
                        ->where('patente', $licensePlate)
                        ->firstOrFail();

        return ApiResponse::success(data: new VehicleWithOwnerResource($vehicle));
    }

    public function byRut(string $rut)
    {
        $owner = Owner::with(['contacts.type'])
            ->where('rut', $rut)
            ->firstOrFail();

        $vehicles = Vehicle::whereHas('owner', function ($q) use ($rut) {
            $q->where('rut', $rut);
        })->simplePaginate(10);

        return ApiResponse::success(data: new OwnerVehiclesResource(
            owner: $owner,
            vehicles: $vehicles
        ));
    }
}
