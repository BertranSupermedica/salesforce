#!/bin/bash

echo "=== Corrigindo problemas Composer + Oracle no PHP 8.4 ==="

# 1. Instalar extensão Oracle para PHP 8.4
echo "1. Instalando extensão Oracle..."

# Adicionar repositório para Oracle Instant Client (se necessário)
if ! dpkg -l | grep -q oracle-instantclient; then
    echo "Baixando Oracle Instant Client..."
    
    # Download dos pacotes Oracle (substitua pelas URLs atuais se necessário)
    cd /tmp
    wget https://download.oracle.com/otn_software/linux/instantclient/2115000/oracle-instantclient-basic-21.15.0.0.0-1.x86_64.rpm
    wget https://download.oracle.com/otn_software/linux/instantclient/2115000/oracle-instantclient-devel-21.15.0.0.0-1.x86_64.rpm
    
    # Converter RPM para DEB (se necessário)
    sudo apt install -y alien
    sudo alien -i oracle-instantclient-basic-*.rpm
    sudo alien -i oracle-instantclient-devel-*.rpm
fi

# Instalar extensões PHP Oracle
echo "Instalando extensões PHP 8.4 Oracle..."
sudo apt update

# Tentar diferentes métodos de instalação
if ! sudo apt install -y php8.4-oci8 2>/dev/null; then
    echo "Instalação via apt falhou, tentando PECL..."
    
    # Instalar via PECL
    sudo apt install -y php8.4-dev php-pear libaio1
    
    # Configurar variáveis Oracle
    export ORACLE_HOME=/usr/lib/oracle/21/client64
    export LD_LIBRARY_PATH=$ORACLE_HOME/lib
    
    # Instalar OCI8 via PECL
    sudo pecl install oci8
    
    # Adicionar extensão ao php.ini
    echo "extension=oci8.so" | sudo tee /etc/php/8.4/cli/conf.d/30-oci8.ini
    echo "extension=oci8.so" | sudo tee /etc/php/8.4/apache2/conf.d/30-oci8.ini
fi

# Verificar se OCI8 foi instalada
echo "Verificando OCI8..."
if php -m | grep -i oci8; then
    echo "✅ OCI8 instalada com sucesso!"
else
    echo "⚠️  OCI8 não detectada, continuando sem Oracle..."
fi

# 2. Voltar ao diretório do projeto
cd /var/www/html/salesforce

# 3. Limpar cache Composer
echo "2. Limpando cache Composer..."
composer clear-cache

# 4. Remover vendor e lock
echo "3. Removendo dependências antigas..."
rm -rf vendor composer.lock

# 5. Instalar sem OCI8 primeiro (se não tiver Oracle)
echo "4. Instalando Laravel básico..."
if ! php -m | grep -i oci8; then
    echo "Instalando sem Oracle primeiro..."
    composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-oci8
else
    composer install --no-dev --optimize-autoloader
fi

# 6. Verificar se vendor foi criado
if [ -d "vendor" ]; then
    echo "✅ Dependências instaladas!"
else
    echo "❌ Erro na instalação das dependências"
    exit 1
fi

# 7. Configurar permissões
echo "5. Configurando permissões..."
mkdir -p storage/{logs,framework/{cache,sessions,views}} bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "Configure o owner manualmente"

# 8. Configurar Laravel
echo "6. Configurando Laravel..."
php artisan key:generate --force
php artisan config:cache
php artisan view:clear

# 9. Teste final
echo "7. Teste final..."
echo "Laravel: $(php artisan --version)"
echo "Autoload: $(ls -la vendor/autoload.php 2>/dev/null || echo 'ERRO')"

# 10. Verificar Oracle novamente
echo "8. Status Oracle:"
if php -m | grep -i oci8; then
    echo "✅ Oracle OCI8 disponível"
    php -r "
    try {
        \$pdo = new PDO('oci:host=192.168.0.199;port=411;dbname=ORCL', 'AN_MER', 'ANMER');
        echo '✅ Conexão Oracle OK';
    } catch(Exception \$e) {
        echo '❌ Conexão Oracle falhou: ' . \$e->getMessage();
    }
    "
else
    echo "⚠️  Oracle não disponível - aplicação funcionará sem Oracle"
fi

echo ""
echo "=== INSTALAÇÃO FINALIZADA ==="
echo ""
echo "PRÓXIMOS PASSOS:"
echo "1. Reiniciar Apache: sudo systemctl restart apache2"
echo "2. Testar: http://seu-servidor/salesforce/public/"
echo "3. Se Oracle não funcionar, configure manualmente"
echo ""
echo "TROUBLESHOOTING Oracle:"
echo "- Verifique: php -m | grep oci"
echo "- Log PHP: tail -f /var/log/apache2/error.log"
echo "- Teste conexão: php diagnostico.php"