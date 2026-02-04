<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    Route::get('/health', HealthController::class);

    Route::middleware('api-secure')->group(function () {

        Route::get('/vehicles/{licensePlate}', [VehicleController::class, 'show']);

        Route::get('/vehicles/by-rut/{rut}', [VehicleController::class, 'byRut']);
    });
});
