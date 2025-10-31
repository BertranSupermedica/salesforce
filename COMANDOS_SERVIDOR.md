# Manual de comandos para resolver no servidor Ubuntu

# 1. Conectar no servidor e navegar para o diretório
cd /var/www/html/salesforce

# 2. Verificar se o Composer está instalado
composer --version

# Se não estiver instalado, instalar o Composer:
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# 3. Instalar extensões PHP 8.4 necessárias
sudo apt update
sudo apt install -y php8.4-mbstring php8.4-xml php8.4-bcmath php8.4-fileinfo php8.4-curl php8.4-zip

# 4. Limpar e instalar dependências Laravel
composer clear-cache
rm -rf vendor composer.lock
composer install --no-dev --optimize-autoloader

# 5. Criar diretórios e configurar permissões
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# 6. Configurar .env (se necessário)
# Já existe, então pular este passo

# 7. Gerar chave da aplicação
php artisan key:generate --force

# 8. Otimizar para produção
php artisan config:cache
php artisan view:clear

# 9. Instalar extensão Oracle (se necessário)
sudo apt install -y php8.4-oci8 php8.4-pdo-oci

# 10. Reiniciar Apache
sudo systemctl restart apache2

# 11. Testar
php artisan --version
ls -la vendor/autoload.php