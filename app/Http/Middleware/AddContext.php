<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class AddContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = $request->attributes->get('apiClient');

        Context::add([
            'api_key_id' => $client->api_key_id,
            'ip' => $request->ip(),
            'trace_id'  => Str::uuid()->toString(),
        ]);
        
        return $next($request);
    }
}
