<?php

use App\Http\Controllers\HealthController;
use App\Http\Controllers\VehicleController;
use App\Http\Middleware\RateLimit;
use App\Http\Middleware\ValidateApiKey;
use App\Http\Middleware\ValidateClientIpMiddleware;
use App\Http\Middleware\ValidateNonce;
use App\Http\Middleware\ValidateApiSignature;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    Route::get('/health', HealthController::class)->withoutMiddleware([
        RateLimit::class,
        ValidateApiKey::class,
        ValidateClientIpMiddleware::class,
        ValidateNonce::class,
        ValidateApiSignature::class,
    ]);

    Route::get('/vehicles/{licensePlate}', [VehicleController::class, 'show']);

    Route::get('/vehicles/by-rut/{rut}', [VehicleController::class, 'byRut']);
});
