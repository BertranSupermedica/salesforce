# SOLUÇÃO RÁPIDA - Remover warnings OCI8 e instalar Laravel 11

# === PASSO 1: Corrigir OCI8 ===

# Remover arquivos de configuração OCI8 problemáticos
sudo rm -f /etc/php/8.4/cli/conf.d/30-oci8.ini
sudo rm -f /etc/php/8.4/apache2/conf.d/30-oci8.ini

# Comentar qualquer extensão oci8 em arquivos ini
sudo sed -i 's/^extension=oci8/#extension=oci8/g' /etc/php/8.4/cli/php.ini
sudo sed -i 's/^extension=oci8/#extension=oci8/g' /etc/php/8.4/apache2/php.ini

# === PASSO 2: Testar PHP limpo ===
php --version
# Não deve mostrar warning agora

# === PASSO 3: Instalar Laravel 11 ===
cd /var/www/html/salesforce

composer clear-cache
rm -rf vendor composer.lock

# Instalar Laravel 11 sem OCI8
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-oci8

# === PASSO 4: Configurar ===
mkdir -p storage/{logs,framework/{cache,sessions,views}} bootstrap/cache
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data .

php artisan key:generate --force
php artisan config:cache

# === PASSO 5: Testar ===
php artisan --version
# Deve mostrar Laravel 11.x

sudo systemctl restart apache2

# TESTE: http://seu-servidor/salesforce/public/