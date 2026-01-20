<?php

namespace App\Http\Middleware;

use App\Enums\Languages;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('Accept-Language');

        if ($lang && in_array($lang, Languages::values(), true) && $lang !== config("app.locale")) {

            App::setLocale($lang);
        }

        return $next($request);
    }
}
