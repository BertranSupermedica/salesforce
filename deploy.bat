@echo off
echo =========================================
echo   Deploy Salesforce Laravel - Windows
echo =========================================
echo.

REM Verificar se está no diretório correto
if not exist "composer.json" (
    echo ❌ Erro: Execute este script no diretório raiz da aplicação
    pause
    exit /b 1
)

echo 📦 Instalando dependências do Composer...
composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ❌ Erro na instalação do Composer
    pause
    exit /b 1
)

echo ⚙️ Configurando ambiente...
if not exist ".env" (
    if exist ".env.production" (
        copy ".env.production" ".env" >nul
        echo ✅ Arquivo .env criado a partir do .env.production
    ) else (
        echo ⚠️ Arquivo .env não encontrado. Configure manualmente.
    )
)

echo 🔐 Gerando chave da aplicação...
for /f %%i in ('php -r "echo base64_encode(random_bytes(32));"') do set APP_KEY_VALUE=%%i
echo APP_KEY=base64:%APP_KEY_VALUE%

REM Atualizar APP_KEY no .env (método simples)
powershell -Command "(Get-Content .env) -replace 'APP_KEY=.*', 'APP_KEY=base64:%APP_KEY_VALUE%' | Set-Content .env"

echo 📂 Configurando permissões Windows...
icacls "storage" /grant Everyone:F /T /Q >nul 2>&1
icacls "bootstrap\cache" /grant Everyone:F /T /Q >nul 2>&1

echo 🧹 Limpando cache...
if exist "bootstrap\cache\*.php" del /q "bootstrap\cache\*.php" >nul 2>&1
if exist "storage\framework\cache\data\*" del /q /s "storage\framework\cache\data\*" >nul 2>&1
if exist "storage\framework\sessions\*" del /q /s "storage\framework\sessions\*" >nul 2>&1  
if exist "storage\framework\views\*" del /q /s "storage\framework\views\*" >nul 2>&1

echo 🔍 Verificando configuração...
php -v | findstr "PHP"
composer --version | findstr "Composer"

echo.
echo ✅ Deploy concluído com sucesso!
echo.
echo 📋 Próximos passos:
echo 1. Configure o arquivo .env com seus dados do Oracle
echo 2. Configure o Virtual Host do Apache (recomendado)
echo 3. Acesse /oracle-test para testar a conexão
echo.
echo 🌐 URLs da aplicação:
echo - Home: http://localhost/salesforce/
echo - BASE ANVISA: http://localhost/salesforce/base-anvisa
echo - Teste Oracle: http://localhost/salesforce/oracle-test
echo.

pause