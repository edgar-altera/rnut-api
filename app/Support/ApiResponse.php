<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function success(
        ?string $message = null,
        int $code = Response::HTTP_OK,
        mixed $data = null
    ): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message ?? Response::$statusTexts[$code] ?? Response::$statusTexts[Response::HTTP_OK],
            'data' => $data,
            'errors' => null,
        ], $code);
    }

    public static function error(
        ?string $message = null,
        int $code = Response::HTTP_BAD_REQUEST,
        mixed $errors = null
    ): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message ?? Response::$statusTexts[$code] ?? Response::$statusTexts[Response::HTTP_BAD_REQUEST],
            'data' => null,
            'errors' => $errors,
        ], $code);
    }
}
