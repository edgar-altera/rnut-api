<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ValidateNonce
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->attributes->get('apiClient');

        if (!$client) {

            throw new AuthenticationException(__('messages.api_key_missing'));
        }
        
        $nonce = $request->header('x-nonce');

        if (!$nonce) {

            throw new AccessDeniedHttpException(__('messages.nonce_missing'));
        }

        if (!Str::isUuid($nonce)) {

            throw new AccessDeniedHttpException(__('messages.nonce_invalid'));
        }

        $cacheKey = "nonce:{$client->id}:{$nonce}";

        if (Cache::has($cacheKey)) {

            throw new AccessDeniedHttpException(__('messages.replay_detected'));
        }

        Cache::put($cacheKey, true, config('api.nonce_ttl'));

        return $next($request);
    }
}
