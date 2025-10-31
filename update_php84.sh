#!/bin/bash

# Script para atualizar Laravel no servidor PHP 8.4
# Execute este script no diretório /var/www/html/salesforce/

echo "=== Atualizando Laravel para PHP 8.4 ==="

# 1. Fazer backup
echo "1. Criando backup..."
cp -r vendor vendor_backup_$(date +%Y%m%d_%H%M%S) 2>/dev/null || echo "Sem vendor para backup"

# 2. Limpar cache do Composer
echo "2. Limpando cache..."
composer clear-cache

# 3. Remover vendor antigo
echo "3. Removendo dependências antigas..."
rm -rf vendor/
rm -f composer.lock

# 4. Instalar novas dependências compatíveis com PHP 8.4
echo "4. Instalando Laravel 10 para PHP 8.4..."
composer install --no-dev --optimize-autoloader

# 5. Configurar permissões
echo "5. Configurando permissões..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 6. Configurar ambiente
echo "6. Configurando ambiente..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "Arquivo .env criado - configure as variáveis!"
fi

# 7. Gerar chave da aplicação
echo "7. Gerando chave da aplicação..."
php artisan key:generate

# 8. Otimizar aplicação para produção
echo "8. Otimizando para produção..."
php artisan config:cache
php artisan route:cache  
php artisan view:cache

# 9. Teste final
echo "9. Testando instalação..."
php artisan --version

echo ""
echo "=== Atualização Completa! ==="
echo ""
echo "CONFIGURAÇÕES MANUAIS NECESSÁRIAS:"
echo "1. Edite .env com suas configurações Oracle:"
echo "   DB_CONNECTION=oracle"
echo "   DB_HOST=192.168.0.199"
echo "   DB_PORT=411"
echo "   DB_DATABASE=ORCL"
echo "   DB_USERNAME=AN_MER"
echo "   DB_PASSWORD=sua_senha"
echo ""
echo "2. Instale extensão Oracle para PHP 8.4:"
echo "   sudo apt-get install php8.4-oci8 php8.4-pdo-oci"
echo ""
echo "3. Reinicie o servidor web:"
echo "   sudo systemctl restart apache2"
echo ""
echo "4. Teste: http://seu-servidor/salesforce/public/"