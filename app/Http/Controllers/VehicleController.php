<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Support\ApiResponse;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function show(Request $request, string $licensePlate)
    {
        $vehicle = Vehicle::where('patente', $licensePlate)->first();

        return ApiResponse::success(data: compact('vehicle'));
    }
}
