#!/bin/bash

echo "=== Instalando Laravel 11 no PHP 8.4 ==="

cd /var/www/html/salesforce

# 1. Backup do projeto atual
echo "1. Fazendo backup..."
cp -r . ../salesforce_backup_$(date +%Y%m%d_%H%M%S) 2>/dev/null || echo "Backup opcional"

# 2. Limpar completamente
echo "2. Limpando projeto..."
rm -rf vendor composer.lock
composer clear-cache

# 3. Instalar Laravel 11 (sem Oracle primeiro)
echo "3. Instalando Laravel 11..."
composer install --no-dev --optimize-autoloader --ignore-platform-req=ext-oci8

if [ ! -d "vendor" ]; then
    echo "❌ Erro na instalação! Tentando método alternativo..."
    
    # Método alternativo: criar projeto Laravel 11 novo
    echo "Criando projeto Laravel 11 do zero..."
    cd /var/www/html
    composer create-project laravel/laravel salesforce11 "^11.0" --prefer-dist
    
    # Copiar arquivos importantes do projeto antigo
    cp salesforce/.env salesforce11/.env 2>/dev/null || echo ".env não copiado"
    cp -r salesforce/app/Models/* salesforce11/app/Models/ 2>/dev/null || echo "Models não copiados"
    cp -r salesforce/app/Http/Controllers/* salesforce11/app/Http/Controllers/ 2>/dev/null || echo "Controllers não copiados"
    cp -r salesforce/resources/views/* salesforce11/resources/views/ 2>/dev/null || echo "Views não copiadas"
    cp salesforce/routes/web.php salesforce11/routes/web.php 2>/dev/null || echo "Routes não copiadas"
    
    # Renomear
    mv salesforce salesforce_old
    mv salesforce11 salesforce
    
    cd /var/www/html/salesforce
fi

# 4. Verificar versão Laravel
echo "4. Verificando instalação..."
php artisan --version

# 5. Configurar permissões
echo "5. Configurando permissões..."
mkdir -p storage/{logs,framework/{cache,sessions,views}} bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data . 2>/dev/null || echo "Configure owner manualmente"

# 6. Configurar aplicação
echo "6. Configurando aplicação..."
php artisan key:generate --force 2>/dev/null || echo "Chave já existe"
php artisan config:cache
php artisan view:clear

# 7. Teste final
echo "7. Teste final..."
php artisan about 2>/dev/null || php artisan --version

echo ""
echo "=== Laravel 11 Instalado! ==="
echo ""
echo "Versão PHP: $(php --version | head -1)"
echo "Versão Laravel: $(php artisan --version)"
echo ""
echo "PRÓXIMOS PASSOS:"
echo "1. Configure .env se necessário"
echo "2. Reinstale Oracle se precisar: pecl install oci8"
echo "3. Reinicie Apache: sudo systemctl restart apache2"
echo "4. Teste: http://seu-servidor/salesforce/public/"
echo ""
echo "ARQUIVOS IMPORTANTES:"
echo "- Laravel 11 bootstrap: bootstrap/app.php"
echo "- Configuração: .env"
echo "- Rotas: routes/web.php"