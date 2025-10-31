<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Create The Application (Laravel 11)
|--------------------------------------------------------------------------
|
| Laravel 11 bootstrap - totalmente compatível com PHP 8.4
|
*/

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware configuration
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Exception handling
    })->create();