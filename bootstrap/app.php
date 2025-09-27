<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware para manejo de idiomas
        $middleware->web(\App\Http\Middleware\SetLanguageMiddleware::class);
        
        // Alias para middlewares de autenticación
        $middleware->alias([
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'check.trial' => \App\Http\Middleware\CheckTrialStatus::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'recaptcha' => \App\Http\Middleware\RecaptchaMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
