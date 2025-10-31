#!/bin/bash

# 🚀 Script de Deploy - Salesforce Laravel
# Execute este script no servidor após fazer upload dos arquivos

echo "🚀 Iniciando deploy da aplicação Salesforce Laravel..."

# Verificar se está no diretório correto
if [ ! -f "composer.json" ]; then
    echo "❌ Erro: Execute este script no diretório raiz da aplicação"
    exit 1
fi

echo "📦 Instalando dependências do Composer..."
composer install --no-dev --optimize-autoloader

echo "⚙️ Configurando ambiente..."
if [ ! -f ".env" ]; then
    if [ -f ".env.production" ]; then
        cp .env.production .env
        echo "✅ Arquivo .env criado a partir do .env.production"
    else
        echo "⚠️ Arquivo .env não encontrado. Configure manualmente."
    fi
fi

echo "🔐 Gerando chave da aplicação..."
APP_KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
if grep -q "APP_KEY=" .env; then
    sed -i "s/APP_KEY=.*/APP_KEY=$APP_KEY/" .env
else
    echo "APP_KEY=$APP_KEY" >> .env
fi
echo "✅ Chave da aplicação gerada: $APP_KEY"

echo "📂 Configurando permissões..."
chmod -R 755 .
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod 600 .env

echo "🧹 Limpando cache..."
rm -rf bootstrap/cache/*.php 2>/dev/null || true
rm -rf storage/framework/cache/data/* 2>/dev/null || true
rm -rf storage/framework/sessions/* 2>/dev/null || true
rm -rf storage/framework/views/* 2>/dev/null || true

echo "🔍 Verificando configuração..."
echo "PHP Version: $(php -v | head -n 1)"
echo "Composer Version: $(composer --version | head -n 1)"

echo ""
echo "✅ Deploy concluído com sucesso!"
echo ""
echo "📋 Próximos passos:"
echo "1. Configure o arquivo .env com seus dados do Oracle"
echo "2. Configure o Virtual Host do Apache (recomendado)"
echo "3. Acesse /oracle-test para testar a conexão"
echo ""
echo "🌐 URLs da aplicação:"
echo "- Home: http://seudominio.com/salesforce/"
echo "- BASE ANVISA: http://seudominio.com/salesforce/base-anvisa"
echo "- Teste Oracle: http://seudominio.com/salesforce/oracle-test"