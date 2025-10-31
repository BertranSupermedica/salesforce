<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Laravel 10 compatível com PHP 8.4
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
*/

$app->singleton(
    'Illuminate\Contracts\Http\Kernel',
    'App\Http\Kernel'
);

$app->singleton(
    'Illuminate\Contracts\Console\Kernel', 
    'App\Console\Kernel'
);

$app->singleton(
    'Illuminate\Contracts\Debug\ExceptionHandler',
    'App\Exceptions\Handler'
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
*/

return $app;