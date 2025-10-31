# Comandos para atualizar Laravel no Windows (PHP 8.4)
# Execute no diretório do projeto

# 1. Limpar cache do Composer
composer clear-cache

# 2. Remover dependências antigas
Remove-Item -Path "vendor" -Recurse -Force -ErrorAction SilentlyContinue
Remove-Item -Path "composer.lock" -Force -ErrorAction SilentlyContinue

# 3. Instalar Laravel 10 compatível com PHP 8.4
composer install

# 4. Configurar ambiente (se necessário)
if (!(Test-Path ".env")) {
    Copy-Item ".env.example" ".env"
    Write-Host "Arquivo .env criado - configure as variáveis!"
}

# 5. Gerar chave
php artisan key:generate

# 6. Teste
php artisan --version

Write-Host "Atualização completa!"
Write-Host "Configure o .env com suas credenciais Oracle e teste o projeto."