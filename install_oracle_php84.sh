#!/bin/bash

echo "=== Instalando Oracle OCI8 para PHP 8.4 ==="

# 1. Instalar dependências necessárias
echo "1. Instalando dependências básicas..."
sudo apt update
sudo apt install -y libaio1 libaio-dev unzip wget php8.4-dev php-pear build-essential

# 2. Baixar e instalar Oracle Instant Client
echo "2. Baixando Oracle Instant Client..."

# Criar diretório para Oracle
sudo mkdir -p /opt/oracle
cd /tmp

# URLs atualizadas do Oracle Instant Client 21c (free)
ORACLE_VERSION="21_15"
BASE_URL="https://download.oracle.com/otn_software/linux/instantclient/2115000"

# Download dos pacotes necessários
echo "Baixando Oracle Instant Client Basic..."
wget -O instantclient-basic.zip "${BASE_URL}/instantclient-basic-linux.x64-21.15.0.0.0dbru.zip"

echo "Baixando Oracle Instant Client SDK..."
wget -O instantclient-sdk.zip "${BASE_URL}/instantclient-sdk-linux.x64-21.15.0.0.0dbru.zip"

# 3. Extrair e configurar Oracle
echo "3. Extraindo Oracle Instant Client..."
sudo unzip -q instantclient-basic.zip -d /opt/oracle/
sudo unzip -q instantclient-sdk.zip -d /opt/oracle/

# Renomear diretório para padrão
sudo mv /opt/oracle/instantclient_${ORACLE_VERSION} /opt/oracle/instantclient 2>/dev/null || echo "Diretório já renomeado"

# 4. Configurar variáveis de ambiente Oracle
echo "4. Configurando variáveis Oracle..."
export ORACLE_HOME="/opt/oracle/instantclient"
export LD_LIBRARY_PATH="$ORACLE_HOME:$LD_LIBRARY_PATH"
export PATH="$ORACLE_HOME:$PATH"

# Adicionar ao sistema
echo "$ORACLE_HOME" | sudo tee /etc/ld.so.conf.d/oracle-instantclient.conf
sudo ldconfig

# Criar links simbólicos necessários
cd $ORACLE_HOME
sudo ln -sf libclntsh.so.21.1 libclntsh.so 2>/dev/null || echo "Link já existe"
sudo ln -sf libocci.so.21.1 libocci.so 2>/dev/null || echo "Link já existe"

# 5. Configurar variáveis permanentes
echo "5. Configurando variáveis permanentes..."
sudo tee /etc/environment << EOF > /dev/null
PATH="$PATH:/opt/oracle/instantclient"
ORACLE_HOME="/opt/oracle/instantclient"
LD_LIBRARY_PATH="/opt/oracle/instantclient:\$LD_LIBRARY_PATH"
TNS_ADMIN="/opt/oracle/instantclient"
EOF

# 6. Instalar extensão OCI8 via PECL
echo "6. Instalando extensão OCI8 via PECL..."

# Configurar PECL com caminho Oracle
export PHP_DTRACE=yes
sudo pecl config-set php_ini /etc/php/8.4/cli/php.ini

# Instalar OCI8 (resposta automática para prompt)
echo "instantclient,/opt/oracle/instantclient" | sudo pecl install oci8

# 7. Configurar PHP para carregar OCI8
echo "7. Configurando PHP..."

# Adicionar extensão ao PHP CLI
echo "extension=oci8.so" | sudo tee /etc/php/8.4/cli/conf.d/20-oci8.ini

# Adicionar extensão ao PHP Apache
echo "extension=oci8.so" | sudo tee /etc/php/8.4/apache2/conf.d/20-oci8.ini

# 8. Verificar instalação
echo "8. Verificando instalação..."

# Recarregar configuração
sudo ldconfig

# Testar se OCI8 foi carregada
echo "Testando OCI8..."
if php -m | grep -i oci8; then
    echo "✅ OCI8 instalada com sucesso!"
    php -r "echo 'OCI8 versão: ' . phpversion('oci8') . PHP_EOL;"
else
    echo "❌ Erro na instalação OCI8"
    echo "Debug: verificando arquivos..."
    ls -la /opt/oracle/instantclient/
    php -r "phpinfo();" | grep -i oci
    exit 1
fi

# 9. Testar conexão Oracle
echo "9. Testando conexão Oracle..."
php -r "
try {
    \$conn = oci_connect('AN_MER', 'ANMER', '192.168.0.199:411/ORCL');
    if (\$conn) {
        echo '✅ Conexão Oracle OK!' . PHP_EOL;
        oci_close(\$conn);
    } else {
        echo '❌ Erro na conexão Oracle' . PHP_EOL;
    }
} catch (Exception \$e) {
    echo '❌ Erro Oracle: ' . \$e->getMessage() . PHP_EOL;
}
"

# 10. Limpar arquivos temporários
echo "10. Limpando arquivos temporários..."
rm -f /tmp/instantclient-*.zip

echo ""
echo "=== ORACLE OCI8 INSTALADO! ==="
echo ""
echo "CONFIGURAÇÃO:"
echo "- Oracle Home: /opt/oracle/instantclient"
echo "- Extensão PHP: oci8.so"
echo "- Versão: $(php -r 'echo phpversion("oci8");' 2>/dev/null || echo 'N/A')"
echo ""
echo "PRÓXIMOS PASSOS:"
echo "1. Reiniciar Apache: sudo systemctl restart apache2"
echo "2. Instalar Laravel 11: cd /var/www/html/salesforce && composer install"
echo "3. Testar: php -r \"echo 'OCI8: ' . (extension_loaded('oci8') ? 'OK' : 'ERRO');\""