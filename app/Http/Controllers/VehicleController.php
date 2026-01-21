<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowVehicleRequest;
use App\Models\Vehicle;
use App\Support\ApiResponse;

class VehicleController extends Controller
{
    public function show(ShowVehicleRequest $request, string $licensePlate)
    {
        $vehicle = Vehicle::where('patente', $licensePlate)->first();

        return ApiResponse::success(data: compact('vehicle'));
    }
}
