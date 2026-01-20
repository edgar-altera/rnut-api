<?php

namespace App\Http\Middleware;

use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureJsonRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('OPTIONS')) {
            
            return $next($request);
        }

        if (!$request->expectsJson()) {
            
            return ApiResponse::error(
                http_message(Response::HTTP_NOT_ACCEPTABLE),
                Response::HTTP_NOT_ACCEPTABLE
            );
        }

        if ($request->header('Content-Type') !== 'application/json') {
            
            return ApiResponse::error(
                http_message(Response::HTTP_UNSUPPORTED_MEDIA_TYPE),
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }

        return $next($request);
    }
}
