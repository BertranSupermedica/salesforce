<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Oracle Test - Salesforce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
        }
        .status-success { color: #28a745; }
        .status-failed { color: #dc3545; }
        .config-table { font-size: 0.9rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-database"></i> Salesforce Laravel
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/oracle-test">Teste Oracle</a>
                <a class="nav-link" href="/api/system-info" target="_blank">System Info API</a>
            </div>
        </div>
    </nav>

    <div class="hero-section py-5">
        <div class="container text-center">
            <h1 class="display-4 mb-4">
                <i class="fas fa-server"></i> Laravel Oracle Connection Test
            </h1>
            <p class="lead">Sistema de análise de mercado - Porta 411</p>
            <div class="mt-4">
                <span class="badge bg-success me-2">Laravel {{ app()->version() }}</span>
                <span class="badge bg-info me-2">PHP {{ PHP_VERSION }}</span>
                <span class="badge bg-warning">Oracle Ready</span>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            @foreach($testResults as $connectionName => $result)
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-database"></i> {{ $connectionName }}
                        </h5>
                        <span class="badge {{ $result['status'] === 'success' ? 'bg-success' : 'bg-danger' }}">
                            {{ $result['status'] === 'success' ? 'CONECTADO' : 'ERRO' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong class="{{ $result['status'] === 'success' ? 'status-success' : 'status-failed' }}">
                                <i class="fas {{ $result['status'] === 'success' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $result['message'] }}
                            </strong>
                        </div>

                        @if($result['status'] === 'success' && $result['test_query'])
                        <div class="alert alert-success">
                            <strong>🎉 Consulta de Teste Executada:</strong><br>
                            <small>
                                Usuário: {{ $result['test_query']->CURRENT_USER }}<br>
                                Data/Hora: {{ $result['test_query']->CURRENT_DATE }}
                            </small>
                        </div>
                        @endif

                        @if($result['error'])
                        <div class="alert alert-danger">
                            <strong>❌ Erro:</strong><br>
                            <small>{{ $result['error'] }}</small>
                        </div>
                        @endif

                        <h6>📋 Configuração:</h6>
                        <table class="table table-sm config-table">
                            <tr>
                                <td><strong>Host:</strong></td>
                                <td>{{ $result['config']['host'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Porta:</strong></td>
                                <td>{{ $result['config']['port'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Database:</strong></td>
                                <td>{{ $result['config']['database'] }}</td>
                            </tr>
                            <tr>
                                <td><strong>Usuário:</strong></td>
                                <td>{{ $result['config']['username'] }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-info-circle"></i> Informações do Sistema</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Laravel Version:</strong> {{ app()->version() }}<br>
                                <strong>PHP Version:</strong> {{ PHP_VERSION }}<br>
                                <strong>Sistema Operacional:</strong> {{ PHP_OS }}
                            </div>
                            <div class="col-md-6">
                                <strong>Servidor Web:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido' }}<br>
                                <strong>Timezone:</strong> {{ date_default_timezone_get() }}<br>
                                <strong>Data/Hora Atual:</strong> {{ date('d/m/Y H:i:s') }}
                            </div>
                        </div>
                        
                        <hr>
                        
                        <h6>📦 Extensões Oracle:</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <span class="badge {{ extension_loaded('oci8') ? 'bg-success' : 'bg-secondary' }}">
                                    OCI8: {{ extension_loaded('oci8') ? 'Disponível' : 'Não disponível' }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <span class="badge {{ extension_loaded('pdo_oci') ? 'bg-success' : 'bg-secondary' }}">
                                    PDO_OCI: {{ extension_loaded('pdo_oci') ? 'Disponível' : 'Não disponível' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary me-2" onclick="window.location.reload()">
                <i class="fas fa-sync-alt"></i> Testar Novamente
            </button>
            <a href="/api/oracle-test" target="_blank" class="btn btn-outline-secondary">
                <i class="fas fa-code"></i> Ver API JSON
            </a>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2024 Salesforce Laravel - Aplicação moderna com Oracle</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>