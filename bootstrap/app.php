<?php

use App\Exceptions\AppExceptionHandler;
use App\Http\Middleware\AddContext;
use App\Http\Middleware\EnsureJsonRequest;
use App\Http\Middleware\RateLimit;
use App\Http\Middleware\SetLang;
use App\Http\Middleware\ValidateApiKey;
use App\Http\Middleware\ValidateClientIpMiddleware;
use App\Http\Middleware\ValidateNonce;
use App\Http\Middleware\ValidateApiSignature;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->group('api-secure', [
            ValidateApiKey::class,
            ValidateClientIpMiddleware::class,
            ValidateApiSignature::class,
            ValidateNonce::class,
            RateLimit::class,
            AddContext::class,
        ]);

        $middleware->append(EnsureJsonRequest::class);
        $middleware->append(SetLang::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        $exceptions->render(new AppExceptionHandler());

    })->create();
