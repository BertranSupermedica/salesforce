# SOLUÇÃO RÁPIDA - Execute no servidor Ubuntu

# === MÉTODO 1: Instalar sem Oracle (mais rápido) ===
cd /var/www/html/salesforce

# Limpar dependências
composer clear-cache
rm -rf vendor composer.lock

# Instalar ignorando Oracle (temporário)
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-oci8

# Configurar permissões
mkdir -p storage/{logs,framework/{cache,sessions,views}} bootstrap/cache
chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache

# Gerar chave
php artisan key:generate --force

# === MÉTODO 2: Instalar Oracle depois ===

# Para Ubuntu 20.04/22.04
sudo apt update
sudo apt install -y libaio1 php8.4-dev php-pear

# Download Oracle Instant Client (escolha a versão correta)
cd /tmp
wget https://download.oracle.com/otn_software/linux/instantclient/2115000/instantclient-basic-linux.x64-21.15.0.0.0dbru.zip
wget https://download.oracle.com/otn_software/linux/instantclient/2115000/instantclient-sdk-linux.x64-21.15.0.0.0dbru.zip

# Extrair e instalar
sudo mkdir -p /opt/oracle
cd /opt/oracle
sudo unzip /tmp/instantclient-basic-*.zip
sudo unzip /tmp/instantclient-sdk-*.zip

# Configurar Oracle
export ORACLE_HOME=/opt/oracle/instantclient_21_15
export LD_LIBRARY_PATH=$ORACLE_HOME
echo "$ORACLE_HOME" | sudo tee /etc/ld.so.conf.d/oracle-instantclient.conf
sudo ldconfig

# Instalar OCI8
sudo pecl install oci8

# Adicionar ao PHP
echo "extension=oci8.so" | sudo tee /etc/php/8.4/cli/conf.d/30-oci8.ini
echo "extension=oci8.so" | sudo tee /etc/php/8.4/apache2/conf.d/30-oci8.ini

# === MÉTODO 3: Usar apenas PDO (alternativa) ===

# Se OCI8 não funcionar, modifique o database config para usar apenas PDO
# Edite config/database.php para remover dependência OCI8

# === TESTE FINAL ===
sudo systemctl restart apache2
php -m | grep oci
php artisan --version

# Testar no navegador: http://seu-servidor/salesforce/public/