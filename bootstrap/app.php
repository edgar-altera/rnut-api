<?php

use App\Exceptions\AppExceptionHandler;
use App\Http\Middleware\AddContext;
use App\Http\Middleware\CheckApiIp;
use App\Http\Middleware\EnsureJsonRequest;
use App\Http\Middleware\RateLimit;
use App\Http\Middleware\SetLang;
use App\Http\Middleware\ValidateApiKey;
use App\Http\Middleware\VerifyApiSignature;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        $middleware->append(CheckApiIp::class);
        $middleware->append(ValidateApiKey::class);
        $middleware->append(VerifyApiSignature::class);
        $middleware->append(AddContext::class);
        $middleware->append(SetLang::class);
        $middleware->append(EnsureJsonRequest::class);
        $middleware->append(RateLimit::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        $exceptions->render(new AppExceptionHandler());

    })->create();
