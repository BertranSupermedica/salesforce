<?php
/**
 * Status da Aplicação Salesforce Laravel
 * Arquivo simples para verificar se tudo está funcionando
 */

header('Content-Type: application/json');

$status = [
    'status' => 'success',
    'message' => 'Aplicação Salesforce Laravel está funcionando!',
    'timestamp' => date('c'),
    'info' => [
        'php_version' => PHP_VERSION,
        'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido',
        'extensions' => [
            'oci8' => extension_loaded('oci8'),
            'pdo_oci' => extension_loaded('pdo_oci'),
            'mbstring' => extension_loaded('mbstring'),
            'curl' => extension_loaded('curl'),
            'json' => extension_loaded('json')
        ],
        'files' => [
            'vendor_autoload' => file_exists(__DIR__ . '/vendor/autoload.php'),
            'env_file' => file_exists(__DIR__ . '/.env'),
            'bootstrap_app' => file_exists(__DIR__ . '/bootstrap/app.php'),
            'public_index' => file_exists(__DIR__ . '/public/index.php')
        ]
    ],
    'urls' => [
        'home' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/',
        'welcome' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/index.php',
        'laravel_app' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/public/',
        'test_config' => 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/teste.php'
    ]
];

echo json_encode($status, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>