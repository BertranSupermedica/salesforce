# 🚀 Guia de Instalação para Servidor Web

Este guia explica como configurar a aplicação Laravel para rodar em um servidor web de produção.

## 📁 Estrutura Correta do Projeto

A aplicação agora está estruturada corretamente com a pasta `public`:

```
salesforce/
├── app/                          # Classes da aplicação
├── bootstrap/                    # Arquivos de inicialização
├── config/                       # Arquivos de configuração  
├── public/                       # 🌐 PASTA PÚBLICA (Document Root)
│   ├── index.php                 # Ponto de entrada principal
│   └── .htaccess                 # Configurações Apache
├── resources/                    # Views, assets, lang
├── routes/                       # Definição de rotas
├── storage/                      # Logs, cache, uploads
├── vendor/                       # Dependências do Composer
├── .env                         # Variáveis de ambiente
├── .htaccess                    # Redirecionamento para public/
└── composer.json                # Dependências
```

## 🌐 Configuração do Servidor Web

### Opção 1: Apache Virtual Host (Recomendado para Produção)

Crie um Virtual Host apontando diretamente para a pasta `public`:

```apache
<VirtualHost *:80>
    ServerName salesforce.seudominio.com
    DocumentRoot /path/to/salesforce/public
    
    <Directory /path/to/salesforce/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
        
        # Habilitar rewrite
        RewriteEngine On
    </Directory>
    
    # Logs
    ErrorLog ${APACHE_LOG_DIR}/salesforce_error.log
    CustomLog ${APACHE_LOG_DIR}/salesforce_access.log combined
</VirtualHost>
```

### Opção 2: Subdiretório (Situação Atual)

Se você precisar rodar em um subdiretório (como `localhost/salesforce`):

1. **Estrutura atual está OK**: O `.htaccess` na raiz redireciona para `public/`
2. **URL de acesso**: `http://seudominio.com/salesforce/`
3. **Document Root**: Pasta `salesforce/` (não a `public/`)

## ⚙️ Configuração de Permissões

### Linux/Ubuntu:
```bash
# Dar permissões para o servidor web
sudo chown -R www-data:www-data /path/to/salesforce
sudo chmod -R 755 /path/to/salesforce
sudo chmod -R 775 /path/to/salesforce/storage
sudo chmod -R 775 /path/to/salesforce/bootstrap/cache
```

### Windows (XAMPP/WAMP):
```cmd
# Dar permissões completas para as pastas necessárias
icacls "C:\path\to\salesforce\storage" /grant Everyone:F /T
icacls "C:\path\to\salesforce\bootstrap\cache" /grant Everyone:F /T
```

## 🔧 Configuração do PHP

### Extensões Necessárias:
```ini
; php.ini
extension=oci8          ; Para Oracle
extension=pdo_oci       ; PDO Oracle  
extension=mbstring      ; Manipulação de strings
extension=curl          ; Requisições HTTP
extension=openssl       ; Criptografia
extension=json          ; JSON
extension=xml           ; XML
```

### Configurações Recomendadas:
```ini
; php.ini para produção
memory_limit = 512M
max_execution_time = 300
max_input_time = 300
post_max_size = 64M
upload_max_filesize = 64M
session.cookie_secure = On      ; Se usar HTTPS
session.cookie_httponly = On
```

## 🔐 Configuração de Segurança

### 1. Arquivo `.env`
```bash
# Produção
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:SUA_CHAVE_AQUI_32_CARACTERES

# Oracle Database
DB_HOST=192.168.0.199
DB_PORT=411
DB_DATABASE=ORCL
DB_USERNAME=AN_MER
DB_PASSWORD=SUA_SENHA_SEGURA
```

### 2. Gerar Chave da Aplicação
```bash
# No servidor, gere uma chave segura
php -r "echo 'APP_KEY=base64:'.base64_encode(random_bytes(32)).PHP_EOL;"
```

### 3. Permissões de Arquivo
```bash
# .env deve ter permissões restritas
chmod 600 .env
```

## 📋 Checklist de Instalação

### ✅ Pré-requisitos
- [ ] PHP 8.2+ instalado
- [ ] Extensão OCI8 para Oracle
- [ ] Composer instalado
- [ ] Apache com mod_rewrite habilitado

### ✅ Instalação
1. [ ] Upload dos arquivos para o servidor
2. [ ] Executar `composer install --no-dev --optimize-autoloader`
3. [ ] Configurar `.env` com dados corretos
4. [ ] Configurar Virtual Host ou verificar .htaccess
5. [ ] Definir permissões corretas
6. [ ] Testar conexão Oracle

### ✅ Comandos de Instalação
```bash
# 1. Navegar para o diretório
cd /path/to/salesforce

# 2. Instalar dependências (produção)
composer install --no-dev --optimize-autoloader

# 3. Copiar configuração de ambiente
cp .env.example .env

# 4. Editar .env com seus dados
nano .env

# 5. Gerar chave da aplicação
php -r "echo 'APP_KEY=base64:'.base64_encode(random_bytes(32)).PHP_EOL;"

# 6. Limpar cache (se necessário)
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*
```

## 🌐 URLs de Acesso

### Desenvolvimento Local:
- **Home**: `http://localhost/salesforce/`
- **BASE ANVISA**: `http://localhost/salesforce/base-anvisa`
- **Teste Oracle**: `http://localhost/salesforce/oracle-test`

### Produção (Virtual Host):
- **Home**: `http://salesforce.seudominio.com/`
- **BASE ANVISA**: `http://salesforce.seudominio.com/base-anvisa`
- **Teste Oracle**: `http://salesforce.seudominio.com/oracle-test`

### Produção (Subdiretório):
- **Home**: `http://seudominio.com/salesforce/`
- **BASE ANVISA**: `http://seudominio.com/salesforce/base-anvisa`
- **Teste Oracle**: `http://seudominio.com/salesforce/oracle-test`

## 🔍 Resolução de Problemas

### Problema: "404 Not Found"
**Solução**: Verificar se `mod_rewrite` está habilitado no Apache
```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### Problema: "Permission denied"
**Solução**: Verificar permissões das pastas `storage/` e `bootstrap/cache/`

### Problema: "Oracle connection failed"
**Solução**: 
1. Verificar se OCI8 está instalado: `php -m | grep oci8`
2. Testar conectividade: `telnet 192.168.0.199 411`
3. Verificar credenciais no `.env`

### Problema: "Class not found"
**Solução**: Executar `composer dump-autoload --optimize`

## 📊 Monitoramento

### Health Check
- **URL**: `/oracle-test` - Testa conexão com Oracle
- **API**: `/api/system-info` - Informações do sistema em JSON

### Logs
- **Laravel**: `storage/logs/laravel.log`
- **Apache**: `/var/log/apache2/error.log`

---

## 🎯 Resumo para Seu Servidor

1. **Upload**: Faça upload de todos os arquivos
2. **Composer**: Execute `composer install --no-dev`
3. **Configurar**: Edite o arquivo `.env` 
4. **Permissões**: Configure permissões das pastas
5. **Testar**: Acesse `/oracle-test` para verificar

A aplicação está pronta para produção! 🚀