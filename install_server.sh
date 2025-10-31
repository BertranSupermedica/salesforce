#!/bin/bash

echo "=== Instalando Laravel no servidor PHP 8.4 ==="
echo "Executando em: $(pwd)"

# Verificar se estamos no diretório correto
if [ ! -f "composer.json" ]; then
    echo "ERRO: composer.json não encontrado!"
    echo "Execute este script no diretório /var/www/html/salesforce/"
    exit 1
fi

# 1. Verificar se o Composer está instalado
echo "1. Verificando Composer..."
if ! command -v composer &> /dev/null; then
    echo "Instalando Composer..."
    
    # Download e instalação do Composer
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    sudo chmod +x /usr/local/bin/composer
    
    echo "Composer instalado com sucesso!"
else
    echo "✅ Composer já instalado: $(composer --version)"
fi

# 2. Verificar extensões PHP necessárias
echo ""
echo "2. Verificando extensões PHP 8.4..."

required_extensions=("mbstring" "xml" "ctype" "json" "bcmath" "fileinfo" "openssl" "pdo" "tokenizer")
missing_extensions=()

for ext in "${required_extensions[@]}"; do
    if php -m | grep -qi "^$ext$"; then
        echo "✅ $ext"
    else
        echo "❌ $ext - FALTANDO"
        missing_extensions+=($ext)
    fi
done

# Instalar extensões faltantes
if [ ${#missing_extensions[@]} -gt 0 ]; then
    echo ""
    echo "Instalando extensões PHP faltantes..."
    for ext in "${missing_extensions[@]}"; do
        case $ext in
            "mbstring")
                sudo apt-get install -y php8.4-mbstring
                ;;
            "xml")
                sudo apt-get install -y php8.4-xml
                ;;
            "bcmath")
                sudo apt-get install -y php8.4-bcmath
                ;;
            "fileinfo")
                sudo apt-get install -y php8.4-fileinfo
                ;;
            *)
                echo "Instale manualmente: sudo apt-get install php8.4-$ext"
                ;;
        esac
    done
fi

# 3. Instalar dependências do Laravel
echo ""
echo "3. Instalando dependências Laravel..."

# Limpar cache anterior
composer clear-cache 2>/dev/null || echo "Cache Composer limpo"

# Remover vendor antigo se existir
if [ -d "vendor" ]; then
    echo "Removendo vendor antigo..."
    rm -rf vendor
fi

# Remover lock antigo
if [ -f "composer.lock" ]; then
    rm -f composer.lock
fi

# Instalar dependências
echo "Executando: composer install --no-dev --optimize-autoloader"
composer install --no-dev --optimize-autoloader

# Verificar se vendor foi criado
if [ -d "vendor" ]; then
    echo "✅ Dependências instaladas com sucesso!"
else
    echo "❌ ERRO: vendor não foi criado!"
    exit 1
fi

# 4. Configurar permissões
echo ""
echo "4. Configurando permissões..."

# Criar diretórios se não existirem
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache

# Configurar permissões
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "Ajuste o owner manualmente se necessário"

# 5. Configurar arquivo .env
echo ""
echo "5. Configurando ambiente..."
if [ ! -f ".env" ]; then
    if [ -f ".env.example" ]; then
        cp .env.example .env
        echo "✅ .env criado a partir do .env.example"
    else
        echo "❌ .env.example não encontrado"
    fi
fi

# 6. Gerar chave da aplicação
echo ""
echo "6. Gerando chave da aplicação..."
php artisan key:generate --force

# 7. Cache de configuração para produção
echo ""
echo "7. Otimizando para produção..."
php artisan config:cache
php artisan route:cache 2>/dev/null || echo "Rotas não cacheadas (normal se não há rotas)"
php artisan view:clear

# 8. Teste final
echo ""
echo "8. Teste final..."
echo "Versão Laravel: $(php artisan --version)"
echo "Arquivo autoload: $(ls -la vendor/autoload.php)"

# 9. Verificar Oracle (opcional)
echo ""
echo "9. Verificando Oracle..."
if php -m | grep -qi "oci8\|pdo_oci"; then
    echo "✅ Extensão Oracle encontrada"
else
    echo "⚠️  Extensão Oracle não encontrada"
    echo "   Instale com: sudo apt-get install php8.4-oci8 php8.4-pdo-oci"
fi

echo ""
echo "=== INSTALAÇÃO COMPLETA! ==="
echo ""
echo "PRÓXIMOS PASSOS:"
echo "1. Configure .env com suas credenciais Oracle"
echo "2. Instale extensão Oracle se necessário"
echo "3. Reinicie Apache: sudo systemctl restart apache2"
echo "4. Teste: http://seu-servidor/salesforce/public/"
echo ""
echo "ARQUIVOS IMPORTANTES:"
echo "- Configuração: .env"
echo "- Log de erros: storage/logs/laravel.log"
echo "- Autoload: vendor/autoload.php"