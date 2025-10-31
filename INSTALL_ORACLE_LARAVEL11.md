# INSTALAÇÃO COMPLETA ORACLE OCI8 + LARAVEL 11 PHP 8.4

# === PASSO 1: Instalar Oracle Instant Client ===

# Instalar dependências
sudo apt update
sudo apt install -y libaio1 libaio-dev unzip wget php8.4-dev php-pear build-essential

# Criar diretório Oracle
sudo mkdir -p /opt/oracle
cd /tmp

# Download Oracle Instant Client 21c (Free)
wget https://download.oracle.com/otn_software/linux/instantclient/2115000/instantclient-basic-linux.x64-21.15.0.0.0dbru.zip
wget https://download.oracle.com/otn_software/linux/instantclient/2115000/instantclient-sdk-linux.x64-21.15.0.0.0dbru.zip

# Extrair
sudo unzip instantclient-basic-*.zip -d /opt/oracle/
sudo unzip instantclient-sdk-*.zip -d /opt/oracle/
sudo mv /opt/oracle/instantclient_* /opt/oracle/instantclient

# === PASSO 2: Configurar Oracle ===

# Variáveis de ambiente
export ORACLE_HOME="/opt/oracle/instantclient"
export LD_LIBRARY_PATH="$ORACLE_HOME"

# Configurar sistema
echo "/opt/oracle/instantclient" | sudo tee /etc/ld.so.conf.d/oracle-instantclient.conf
sudo ldconfig

# Links simbólicos
cd /opt/oracle/instantclient
sudo ln -sf libclntsh.so.21.1 libclntsh.so
sudo ln -sf libocci.so.21.1 libocci.so

# === PASSO 3: Instalar OCI8 ===

# Instalar via PECL
echo "instantclient,/opt/oracle/instantclient" | sudo pecl install oci8

# Configurar PHP
echo "extension=oci8.so" | sudo tee /etc/php/8.4/cli/conf.d/20-oci8.ini
echo "extension=oci8.so" | sudo tee /etc/php/8.4/apache2/conf.d/20-oci8.ini

# === PASSO 4: Verificar OCI8 ===
php -m | grep oci8
# Deve mostrar: oci8

# Testar conexão
php -r "
\$conn = oci_connect('AN_MER', 'ANMER', '192.168.0.199:411/ORCL');
echo \$conn ? 'Oracle OK' : 'Oracle ERRO';
"

# === PASSO 5: Instalar Laravel 11 ===
cd /var/www/html/salesforce

# Agora COM suporte Oracle completo
composer clear-cache
rm -rf vendor composer.lock
composer install --no-dev --optimize-autoloader

# === PASSO 6: Configurar Laravel ===
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data .
php artisan key:generate --force
php artisan config:cache

# === PASSO 7: Testar ===
php artisan --version  # Laravel 11.x
sudo systemctl restart apache2

# TESTE COMPLETO: http://seu-servidor/salesforce/public/base-anvisa