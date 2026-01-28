<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ValidateClientIpMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->attributes->get('apiClient');

        if (! $client) {

            throw new AuthenticationException(__('messages.api_key_missing'));
        }

        $ip = $request->ip();

        $allowedIps = Cache::remember(
            "api_client_ips:{$client->id}",
            600,
            fn () =>
                $client->allowedIps()
                    ->where('is_active', true)
                    ->pluck('ip')
                    ->toArray()
        );

        if (! in_array($ip, $allowedIps, true)) {
            
            throw new AccessDeniedHttpException(__('messages.ip_not_allowed', ['ip' => $ip ]));
        }

        return $next($request);
    }
}
