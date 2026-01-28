<?php

namespace App\Exceptions;

use App\Support\ApiResponse; 
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class AppExceptionHandler
{
    public function __invoke(Throwable $th)
    {
        Log::error($th->getMessage());

        if ($th instanceof AuthenticationException) {
                
            return ApiResponse::error(
                http_message(Response::HTTP_UNAUTHORIZED),
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($th instanceof AccessDeniedHttpException) {
                
            return ApiResponse::error(
                http_message(Response::HTTP_FORBIDDEN),
                Response::HTTP_FORBIDDEN
            );
        }

        if ($th instanceof ValidationException) {
            return ApiResponse::error(
                http_message(Response::HTTP_UNPROCESSABLE_ENTITY),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $th->errors()
            );
        }

        if ($th instanceof NotFoundHttpException) {
            return ApiResponse::error(
                http_message(Response::HTTP_NOT_FOUND),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($th instanceof MethodNotAllowedHttpException) {
                
            return ApiResponse::error(
                http_message(Response::HTTP_METHOD_NOT_ALLOWED),
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }

        if ($th instanceof ThrottleRequestsException) {

            $headers = $th->getHeaders();

            $retry_after = $headers['Retry-After'] ?? null; // in seconds

            $time = humanize_seconds($retry_after);
                
            return ApiResponse::error(
                http_message(Response::HTTP_TOO_MANY_REQUESTS, compact('time')),
                Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        if ($th instanceof HttpException && $th->getStatusCode() === Response::HTTP_SERVICE_UNAVAILABLE) {
                
            return ApiResponse::error(
                http_message(Response::HTTP_SERVICE_UNAVAILABLE),
                Response::HTTP_SERVICE_UNAVAILABLE
            );
        }

        return ApiResponse::error(
            http_message(Response::HTTP_INTERNAL_SERVER_ERROR),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
