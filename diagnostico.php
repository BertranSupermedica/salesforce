<?php
// Teste de compatibilidade PHP 8.4 com Laravel
echo "<h1>Teste PHP 8.4 + Laravel</h1>";

// 1. Informações do PHP
echo "<h2>1. Versão PHP</h2>";
echo "<p><strong>Versão:</strong> " . phpversion() . "</p>";
echo "<p><strong>Zend Engine:</strong> " . zend_version() . "</p>";

// 2. Teste do Autoloader Composer
echo "<h2>2. Composer Autoload</h2>";
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require __DIR__ . '/vendor/autoload.php';
    echo "<p>✅ Autoload carregado com sucesso</p>";
} else {
    echo "<p>❌ vendor/autoload.php não encontrado</p>";
    echo "<p><strong>Solução:</strong> Execute 'composer install' no diretório raiz</p>";
}

// 3. Teste do Bootstrap Laravel
echo "<h2>3. Bootstrap Laravel</h2>";
if (file_exists(__DIR__ . '/bootstrap/app.php')) {
    echo "<p>✅ bootstrap/app.php encontrado</p>";
    
    try {
        $app = require __DIR__ . '/bootstrap/app.php';
        echo "<p>✅ Bootstrap Laravel carregado</p>";
        echo "<p><strong>Tipo do App:</strong> " . get_class($app) . "</p>";
        
        // Teste das classes do Laravel
        if (class_exists('Illuminate\Foundation\Application')) {
            echo "<p>✅ Classe Application disponível</p>";
        } else {
            echo "<p>❌ Classe Application não encontrada</p>";
        }
        
        if (class_exists('Illuminate\Contracts\Http\Kernel')) {
            echo "<p>✅ Kernel HTTP disponível</p>";
        } else {
            echo "<p>❌ Kernel HTTP não encontrado</p>";
        }
        
        if (class_exists('Illuminate\Http\Request')) {
            echo "<p>✅ Classe Request disponível</p>";
        } else {
            echo "<p>❌ Classe Request não encontrada</p>";
        }
        
    } catch (Exception $e) {
        echo "<p>❌ Erro no Bootstrap: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>❌ bootstrap/app.php não encontrado</p>";
}

// 4. Extensões PHP necessárias
echo "<h2>4. Extensões PHP</h2>";
$extensions = ['pdo', 'pdo_oci', 'oci8', 'mbstring', 'openssl', 'fileinfo', 'tokenizer'];

foreach ($extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "<p>✅ {$ext}</p>";
    } else {
        echo "<p>❌ {$ext} - não carregada</p>";
    }
}

// 5. Permissões de diretório
echo "<h2>5. Permissões</h2>";
$directories = ['storage', 'storage/logs', 'storage/framework', 'bootstrap/cache'];

foreach ($directories as $dir) {
    if (is_dir(__DIR__ . '/' . $dir)) {
        if (is_writable(__DIR__ . '/' . $dir)) {
            echo "<p>✅ {$dir} - gravável</p>";
        } else {
            echo "<p>❌ {$dir} - sem permissão de escrita</p>";
        }
    } else {
        echo "<p>❌ {$dir} - diretório não existe</p>";
    }
}

// 6. Arquivo .env
echo "<h2>6. Configuração</h2>";
if (file_exists(__DIR__ . '/.env')) {
    echo "<p>✅ .env encontrado</p>";
    
    // Verificar APP_KEY
    $envContent = file_get_contents(__DIR__ . '/.env');
    if (strpos($envContent, 'APP_KEY=base64:') !== false) {
        echo "<p>✅ APP_KEY configurada</p>";
    } else {
        echo "<p>❌ APP_KEY não configurada - execute 'php artisan key:generate'</p>";
    }
} else {
    echo "<p>❌ .env não encontrado - copie .env.example para .env</p>";
}

echo "<h2>7. Comando de Solução</h2>";
echo "<p>Se houver problemas, execute na ordem:</p>";
echo "<ol>";
echo "<li><code>composer install</code></li>";
echo "<li><code>cp .env.example .env</code> (se .env não existir)</li>";
echo "<li><code>php artisan key:generate</code></li>";
echo "<li><code>chmod -R 775 storage bootstrap/cache</code> (Linux)</li>";
echo "</ol>";
?>