<?php
/**
 * Teste Rápido da Aplicação Salesforce Laravel
 * 
 * Execute este arquivo para verificar se a configuração está correta
 * URL: http://seudominio.com/salesforce/teste.php
 */

echo "<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teste da Aplicação</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
        .test-item { margin: 10px 0; padding: 10px; border-left: 4px solid #ddd; }
        .test-success { border-left-color: #28a745; }
        .test-error { border-left-color: #dc3545; }
        .test-warning { border-left-color: #ffc107; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🚀 Teste da Aplicação Salesforce Laravel</h1>
        <hr>";

// Informações básicas
echo "<div class='test-item'>
        <strong>Data/Hora:</strong> " . date('d/m/Y H:i:s') . "<br>
        <strong>Servidor:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido') . "<br>
        <strong>PHP Version:</strong> " . PHP_VERSION . "
      </div>";

// Teste 1: PHP Version
$phpOk = version_compare(PHP_VERSION, '8.1.0', '>=');
echo "<div class='test-item " . ($phpOk ? 'test-success' : 'test-error') . "'>
        <strong>✓ PHP 8.1+:</strong> 
        <span class='" . ($phpOk ? 'success' : 'error') . "'>
            " . PHP_VERSION . " " . ($phpOk ? '(OK)' : '(Requer 8.1+)') . "
        </span>
      </div>";

// Teste 2: Extensões PHP
$extensions = ['mbstring', 'json', 'curl', 'openssl', 'oci8', 'pdo_oci'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $critical = in_array($ext, ['mbstring', 'json', 'oci8']);
    
    echo "<div class='test-item " . ($loaded ? 'test-success' : ($critical ? 'test-error' : 'test-warning')) . "'>
            <strong>✓ Extensão {$ext}:</strong> 
            <span class='" . ($loaded ? 'success' : ($critical ? 'error' : 'warning')) . "'>
                " . ($loaded ? 'Carregada' : 'Não encontrada') . 
                ($critical && !$loaded ? ' (OBRIGATÓRIA)' : '') . "
            </span>
          </div>";
}

// Teste 3: Arquivos e pastas
$paths = [
    '.env' => 'Arquivo de configuração',
    'vendor/autoload.php' => 'Dependências do Composer',
    'bootstrap/app.php' => 'Bootstrap da aplicação',
    'public/index.php' => 'Arquivo público principal',
    'storage' => 'Pasta de armazenamento',
    'bootstrap/cache' => 'Cache do bootstrap'
];

foreach ($paths as $path => $desc) {
    $exists = file_exists(__DIR__ . '/' . $path);
    $writable = is_writable(__DIR__ . '/' . $path);
    
    echo "<div class='test-item " . ($exists ? 'test-success' : 'test-error') . "'>
            <strong>✓ {$desc}:</strong> 
            <span class='" . ($exists ? 'success' : 'error') . "'>
                " . ($exists ? 'Encontrado' : 'Não encontrado') . "
            </span>";
    
    if ($exists && in_array($path, ['storage', 'bootstrap/cache'])) {
        echo " <span class='" . ($writable ? 'success' : 'warning') . "'>
                (" . ($writable ? 'Gravável' : 'Sem permissão de escrita') . ")
              </span>";
    }
    
    echo "</div>";
}

// Teste 4: Configuração do .env
if (file_exists(__DIR__ . '/.env')) {
    $envContent = file_get_contents(__DIR__ . '/.env');
    $hasAppKey = strpos($envContent, 'APP_KEY=base64:') !== false && 
                 strpos($envContent, 'APP_KEY=base64:') !== strpos($envContent, 'APP_KEY=base64:$(');
    $hasDbConfig = strpos($envContent, 'DB_HOST=') !== false;
    
    echo "<div class='test-item " . ($hasAppKey ? 'test-success' : 'test-warning') . "'>
            <strong>✓ APP_KEY configurada:</strong> 
            <span class='" . ($hasAppKey ? 'success' : 'warning') . "'>
                " . ($hasAppKey ? 'Configurada' : 'Não configurada (execute deploy.bat/sh)') . "
            </span>
          </div>";
          
    echo "<div class='test-item " . ($hasDbConfig ? 'test-success' : 'test-error') . "'>
            <strong>✓ Configuração do banco:</strong> 
            <span class='" . ($hasDbConfig ? 'success' : 'error') . "'>
                " . ($hasDbConfig ? 'Configurada' : 'Não configurada') . "
            </span>
          </div>";
}

// Teste 5: Teste de conexão Oracle (se disponível)
if (extension_loaded('oci8')) {
    echo "<div class='test-item test-success'>
            <strong>✓ Oracle OCI8:</strong> 
            <span class='success'>Extensão disponível</span>
          </div>";
    
    // Tentar ler configuração
    if (file_exists(__DIR__ . '/.env')) {
        $envContent = file_get_contents(__DIR__ . '/.env');
        preg_match('/DB_HOST=(.+)/', $envContent, $hostMatch);
        preg_match('/DB_PORT=(.+)/', $envContent, $portMatch);
        
        $host = $hostMatch[1] ?? '';
        $port = $portMatch[1] ?? '';
        
        if ($host && $port) {
            echo "<div class='test-item test-info'>
                    <strong>✓ Configuração Oracle:</strong> 
                    <span class='info'>Host: {$host}, Porta: {$port}</span>
                  </div>";
        }
    }
}

// Links úteis
echo "<hr>
      <h3>🔗 Links da Aplicação:</h3>
      <ul>
        <li><a href='./'>🏠 Página Inicial</a></li>
        <li><a href='./base-anvisa'>💊 BASE ANVISA</a></li>
        <li><a href='./oracle-test'>🔍 Teste Oracle</a></li>
        <li><a href='./api/system-info' target='_blank'>🔧 API System Info</a></li>
      </ul>";

// Resumo
$allOk = $phpOk && extension_loaded('mbstring') && extension_loaded('oci8') && 
         file_exists(__DIR__ . '/.env') && file_exists(__DIR__ . '/vendor/autoload.php');

echo "<hr>
      <h3 class='" . ($allOk ? 'success' : 'error') . "'>
        " . ($allOk ? '🎉 Aplicação pronta para uso!' : '⚠️ Existem problemas que precisam ser resolvidos') . "
      </h3>";

if (!$allOk) {
    echo "<p><strong>Ações necessárias:</strong></p>
          <ul>";
    
    if (!$phpOk) echo "<li>Atualizar PHP para versão 8.1+</li>";
    if (!extension_loaded('oci8')) echo "<li>Instalar extensão OCI8 para Oracle</li>";
    if (!file_exists(__DIR__ . '/vendor/autoload.php')) echo "<li>Executar: composer install</li>";
    if (!file_exists(__DIR__ . '/.env')) echo "<li>Criar arquivo .env</li>";
    
    echo "</ul>";
}

echo "    </div>
    </body>
    </html>";
?>