<?php

namespace App\Http\Middleware;

use App\Models\ApiClient;
use Carbon\Carbon;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKeyId = $request->header('x-api-key-id');

        $apiKey = $request->header('x-api-key');

        if (!$apiKeyId || ! $apiKey) {

            throw new AuthenticationException(__('messages.api_key_missing'));
        }

        $apiClient = Cache::remember(
            "api_client:{$apiKeyId}",
            config('api.client_cache_ttl'),
            fn () => ApiClient::where('api_key_id', $apiKeyId)
                ->where('is_active', 1)
                ->first()
        );

        $expectedHash = hash_hmac(
            'sha256',
            $apiKey,
            config('app.key')
        );

        if (!$apiClient || $apiClient->api_key_hash !== $expectedHash) {

            throw new AuthenticationException(__('messages.api_key_invalid'));
        }

        $request->attributes->set('apiClient', $apiClient);

        $apiClient->update([
            'last_used_at' => Carbon::now()
        ]);

        return $next($request);
    }
}
