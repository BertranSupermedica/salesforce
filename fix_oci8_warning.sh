#!/bin/bash

echo "=== Corrigindo problema OCI8 no PHP 8.4 ==="

# 1. Remover configurações OCI8 problemáticas
echo "1. Removendo configurações OCI8 problemáticas..."

# Verificar e comentar/remover oci8.so dos arquivos PHP ini
if [ -f "/etc/php/8.4/cli/conf.d/30-oci8.ini" ]; then
    echo "Removendo /etc/php/8.4/cli/conf.d/30-oci8.ini"
    sudo rm -f /etc/php/8.4/cli/conf.d/30-oci8.ini
fi

if [ -f "/etc/php/8.4/apache2/conf.d/30-oci8.ini" ]; then
    echo "Removendo /etc/php/8.4/apache2/conf.d/30-oci8.ini"
    sudo rm -f /etc/php/8.4/apache2/conf.d/30-oci8.ini
fi

# Verificar outros arquivos de configuração
grep -r "extension=oci8" /etc/php/8.4/ 2>/dev/null | while read line; do
    file=$(echo $line | cut -d: -f1)
    echo "Comentando oci8 em: $file"
    sudo sed -i 's/^extension=oci8/#extension=oci8/g' "$file"
done

# 2. Verificar se OCI8 ainda aparece
echo "2. Verificando configuração PHP..."
php -m | grep -i oci || echo "✅ OCI8 removido com sucesso"

# 3. Testar se warning sumiu
echo "3. Testando PHP sem warnings..."
php --version

echo ""
echo "=== OCI8 removido! Agora continue a instalação Laravel 11 ==="
echo ""
echo "Execute:"
echo "cd /var/www/html/salesforce"
echo "composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-oci8"