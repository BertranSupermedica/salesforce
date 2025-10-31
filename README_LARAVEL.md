# Salesforce Laravel - Sistema de Análise de Mercado

Aplicação Laravel moderna configurada para Oracle Database na porta 411.

## 🚀 Características

- **Laravel 10**: Framework PHP mais recente compatível com PHP 8.2.12
- **Oracle Database**: Conexão nativa com Oracle na porta 411
- **Múltiplas Conexões**: Configurado para `oracle` e `oracle_analise_mercado`
- **Interface Moderna**: Bootstrap 5 com design responsivo
- **API REST**: Endpoints para teste e monitoramento

## 📋 Pré-requisitos

### PHP 8.2.12 (✅ Confirmado)
```bash
PHP 8.2.12 (cli) (built: Oct 24 2023 21:15:15) (ZTS Visual C++ 2019 x64)
```

### Extensões PHP Necessárias
- ✅ **oci8**: Para conexão Oracle nativa
- ✅ **pdo_oci**: Para PDO Oracle
- ✅ **mbstring**: Para manipulação de strings
- ✅ **curl**: Para requisições HTTP
- ✅ **openssl**: Para segurança

### Oracle Instant Client
Certifique-se de ter o Oracle Instant Client instalado e configurado.

## 🛠️ Instalação

### 1. Instalar Dependências
```bash
cd C:\xampp\htdocs\salesforce
composer install
```

### 2. Configurar Ambiente
O arquivo `.env` já foi criado com as configurações:
```env
DB_CONNECTION=oracle
DB_HOST=192.168.0.199
DB_PORT=411
DB_DATABASE=ORCL
DB_USERNAME=AN_MER
DB_PASSWORD=ANMER
```

### 3. Gerar Chave da Aplicação
```bash
php artisan key:generate
```

### 4. Configurar Permissões (se necessário)
```bash
# Windows - Dar permissões completas para as pastas
# storage/ e bootstrap/cache/
```

## 🌐 Como Usar

### Acessar a Aplicação
- **Homepage**: `http://localhost/salesforce/`
- **Teste Oracle**: `http://localhost/salesforce/oracle-test`
- **API System Info**: `http://localhost/salesforce/api/system-info`

### Rotas Disponíveis

#### Web Routes
```
GET /                    - Página inicial
GET /oracle-test         - Teste de conexão Oracle
GET /system-info         - Informações do sistema
```

#### API Routes
```
GET /api/oracle-test     - Teste Oracle via JSON
GET /api/system-info     - Info do sistema via JSON
```

## 🔧 Configurações Oracle

### Conexão Principal (oracle)
```php
'oracle' => [
    'driver' => 'oracle',
    'host' => '192.168.0.199',
    'port' => '411',
    'database' => 'ORCL',
    'username' => 'AN_MER',
    'password' => 'ANMER',
    'charset' => 'AL32UTF8',
]
```

### Conexão Análise Mercado (oracle_analise_mercado)
```php
'oracle_analise_mercado' => [
    'driver' => 'oracle',
    'host' => '192.168.0.199',
    'port' => '411',
    'database' => 'ORCL',
    'username' => 'AN_MER',
    'password' => 'ANMER',
    'charset' => 'AL32UTF8',
]
```

## 🧪 Testando a Conexão

### Método 1: Interface Web
1. Acesse `http://localhost/salesforce/oracle-test`
2. Visualize o status das conexões
3. Veja os resultados das consultas de teste

### Método 2: API JSON
```bash
curl http://localhost/salesforce/api/oracle-test
```

### Método 3: Laravel Artisan (quando disponível)
```bash
php artisan tinker
```
```php
// Testar conexão
DB::connection('oracle')->select('SELECT USER FROM DUAL');
DB::connection('oracle_analise_mercado')->select('SELECT SYSDATE FROM DUAL');
```

## 📁 Estrutura de Arquivos Criados

```
salesforce/
├── app/
│   └── Http/
│       └── Controllers/
│           └── OracleTestController.php
├── config/
│   └── database.php
├── resources/
│   └── views/
│       ├── welcome.blade.php
│       └── oracle-test.blade.php
├── routes/
│   └── web.php
├── bootstrap/
│   └── app.php
├── .env
├── composer.json
└── index.php
```

## 🚨 Troubleshooting

### Erro: "Class 'Illuminate\Foundation\Application' not found"
```bash
composer require laravel/framework
```

### Erro: "OCI8 extension not loaded"
1. Verifique se o Oracle Instant Client está instalado
2. Habilite a extensão no `php.ini`
3. Reinicie o Apache

### Erro de Conexão Oracle
1. Verifique se o Oracle está rodando na porta 411
2. Teste conectividade: `telnet 192.168.0.199 411`
3. Confirme credenciais do usuário AN_MER

### Erro de Permissões
```bash
# Windows
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T
```

## 📊 Monitoramento

### System Info API
```bash
curl http://localhost/salesforce/api/system-info
```

Retorna:
```json
{
  "php_version": "8.2.12",
  "laravel_version": "10.x",
  "server_software": "Apache/2.4.x",
  "extensions": {
    "oci8": true,
    "pdo_oci": true,
    "curl": true
  }
}
```

## 🔄 Próximos Passos

1. **Instalar pacote Oracle para Laravel**:
   ```bash
   composer require yajra/laravel-oci8
   ```

2. **Criar Migrations para Oracle**
3. **Implementar Models para análise de mercado**
4. **Adicionar autenticação Laravel**
5. **Criar dashboard de análise**

## 📞 Suporte

- Verifique logs em: `storage/logs/laravel.log`
- Teste conexões na interface web
- Use a API para debugging programático

---
**Aplicação criada com Laravel {{ app()->version() }} e PHP {{ PHP_VERSION }}**