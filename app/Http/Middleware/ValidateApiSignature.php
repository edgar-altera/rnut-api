<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ValidateApiSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiClient = $request->attributes->get('apiClient');

        if (! $apiClient) {

            throw new AuthenticationException(__('messages.api_key_invalid'));
        }

        $signature = $request->header('x-signature');
        
        $timestamp = $request->header('x-timestamp');

        if (! $signature || ! $timestamp) {

            throw new AccessDeniedHttpException(__('messages.signature_missing'));
        }

        if (abs(time() - (int) $timestamp) > config('api.signature_ttl')) {

            throw new AccessDeniedHttpException(__('messages.signature_expired'));
        }

        $nonce = $request->header('x-nonce');

        if (!$nonce) {

            throw new AccessDeniedHttpException(__('messages.nonce_missing'));
        }

        $payload = implode("\n", [
            $request->method(),
            $request->getPathInfo(),
            $request->getQueryString() ?? '',
            $timestamp,
            $nonce,
        ]);

        $expectedSignature = hash_hmac(
            'sha256',
            $payload,
            $apiClient->api_secret
        );

        if (! hash_equals($expectedSignature, $signature)) {
            
            throw new AccessDeniedHttpException(__('messages.signature_invalid'));
        }

        return $next($request);
    }
}
