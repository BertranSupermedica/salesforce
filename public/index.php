<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

// Configuração de erro para PHP 8.4 - suprimir avisos de depreciação Laravel
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

// Tentar carregar Laravel com tratamento de erros melhorado
try {
    // Verificar se o bootstrap existe
    if (!file_exists(__DIR__.'/../bootstrap/app.php')) {
        throw new Exception("Laravel bootstrap/app.php não encontrado. Execute 'composer install' e configure o projeto Laravel.");
    }
    
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Verificar se as classes do Laravel estão disponíveis
    if (!class_exists('Illuminate\Contracts\Http\Kernel')) {
        throw new Exception("Classes do Laravel não carregadas. Verifique se 'composer install' foi executado.");
    }
    
    $kernel = $app->make('Illuminate\Contracts\Http\Kernel');

    $response = $kernel->handle(
        $request = \Illuminate\Http\Request::capture()
    );

    $response->send();
    $kernel->terminate($request, $response);
    
} catch (Error $e) {
    // Erro fatal do PHP 8.4
    echo "<h1>Erro PHP 8.4</h1>";
    echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    
} catch (Exception $e) {
    // Exceção do Laravel/PHP
    echo "<h1>Erro Laravel</h1>";
    echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    
} catch (Throwable $e) {
    // Qualquer outro erro (PHP 8.4)
    echo "<h1>Erro Geral</h1>";
    echo "<p><strong>Tipo:</strong> " . get_class($e) . "</p>";
    echo "<p><strong>Mensagem:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Arquivo:</strong> " . htmlspecialchars($e->getFile()) . "</p>";
    echo "<p><strong>Linha:</strong> " . $e->getLine() . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}