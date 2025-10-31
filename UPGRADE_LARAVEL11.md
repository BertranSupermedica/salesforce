# COMANDOS PARA ATUALIZAR PARA LARAVEL 11 NO SERVIDOR

# === MÉTODO 1: Atualizar projeto atual ===
cd /var/www/html/salesforce

# Limpar dependências
composer clear-cache
rm -rf vendor composer.lock

# Tentar instalar Laravel 11
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-oci8

# === MÉTODO 2: Criar projeto Laravel 11 novo (se método 1 falhar) ===
cd /var/www/html

# Criar novo projeto Laravel 11
composer create-project laravel/laravel salesforce_laravel11 "^11.0"

# Copiar arquivos do projeto antigo
cp salesforce/.env salesforce_laravel11/.env
cp -r salesforce/app/Models/* salesforce_laravel11/app/Models/ 2>/dev/null
cp -r salesforce/app/Http/Controllers/* salesforce_laravel11/app/Http/Controllers/ 2>/dev/null  
cp -r salesforce/resources/views/* salesforce_laravel11/resources/views/ 2>/dev/null
cp salesforce/routes/web.php salesforce_laravel11/routes/web.php

# Fazer backup e substituir
mv salesforce salesforce_backup
mv salesforce_laravel11 salesforce

# === CONFIGURAÇÃO FINAL ===
cd /var/www/html/salesforce

# Permissões
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data .

# Configurar Laravel
php artisan key:generate --force
php artisan config:cache

# === VERIFICAR ===
php artisan --version
php artisan about

# Reiniciar Apache
sudo systemctl restart apache2

# TESTE: http://seu-servidor/salesforce/public/