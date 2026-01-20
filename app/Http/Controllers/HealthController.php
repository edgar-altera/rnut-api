<?php

namespace App\Http\Controllers;

use App\Support\ApiResponse;
use Symfony\Component\HttpFoundation\Response;

class HealthController extends Controller
{
    public function __invoke()
    {
        return ApiResponse::success(
            message: Response::$statusTexts[Response::HTTP_OK], 
            data: [
                'server_time' => now()->toIso8601String()
            ]
        );
    }
}
