<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('x-api-key');

        if (! $apiKey) {

            throw new AccessDeniedHttpException(__('messages.api_key_missing'));
        }

        if (! hash_equals(
            config('services.internal_api.key'),
            hash_hmac('sha256', $apiKey, config('app.key'))
        )) {

            throw new AccessDeniedHttpException(__('messages.api_key_invalid'));
        }

        return $next($request);
    }
}
