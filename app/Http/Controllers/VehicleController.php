<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
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
}
