<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CheckApiIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedIps = config('security.allowed_ips', []);

        $clientIp = $request->ip();

        if (!in_array($clientIp, $allowedIps, true)) {

            $message = __('messages.ip_not_allowed', [
                'ip' => $clientIp
            ]);

            throw new AccessDeniedHttpException($message);
        }

        return $next($request);
    }
}
