<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salesforce Laravel - Sistema de Análise de Mercado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
            color: white; 
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        .feature-card { 
            transition: transform 0.3s; 
            height: 100%;
        }
        .feature-card:hover { 
            transform: translateY(-5px); 
        }
        .status-badge { font-size: 0.8rem; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-chart-line"></i> Salesforce Laravel
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/oracle-test">Teste Oracle</a>
                <a class="nav-link" href="/api/system-info" target="_blank">System Info</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-3 mb-4">
                        <i class="fas fa-rocket"></i><br>
                        Salesforce Laravel
                    </h1>
                    <p class="lead mb-4">Sistema moderno de análise de mercado com Laravel {{ app()->version() }} e Oracle Database</p>
                    <div class="mb-4">
                        <span class="badge bg-success status-badge me-2">Laravel {{ app()->version() }}</span>
                        <span class="badge bg-info status-badge me-2">PHP {{ PHP_VERSION }}</span>
                        <span class="badge bg-warning status-badge me-2">Oracle 411</span>
                        <span class="badge bg-light text-dark status-badge">{{ PHP_OS }}</span>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="/oracle-test" class="btn btn-light btn-lg me-md-2">
                            <i class="fas fa-database"></i> Testar Oracle
                        </a>
                        <a href="/api/system-info" target="_blank" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-info-circle"></i> System Info
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-12">
                    <h2 class="display-5 mb-3">Recursos da Aplicação</h2>
                    <p class="lead text-muted">Aplicação Laravel moderna configurada para Oracle Database</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-database fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Oracle Database</h5>
                            <p class="card-text">Conexão nativa com Oracle Database na porta 411 usando OCI8 e PDO</p>
                            <a href="/oracle-test" class="btn btn-primary">Testar Conexão</a>
                        </div>
                    </div>
                </div>

                        <div class="col-lg-4 col-md-6">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-pills fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">BASE ANVISA</h5>
                            <p class="card-text">Consulta e análise da base de dados de produtos da ANVISA</p>
                            <a href="/base-anvisa" class="btn btn-success">Acessar BASE</a>
                        </div>
                    </div>
                </div>                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-code fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">API REST</h5>
                            <p class="card-text">Interface de programação para integração com outros sistemas</p>
                            <a href="/api/system-info" target="_blank" class="btn btn-warning">Ver API</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">Segurança</h5>
                            <p class="card-text">Aplicação segura com recursos modernos do Laravel</p>
                            <button class="btn btn-info" disabled>Configurado</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-mobile-alt fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title">Responsivo</h5>
                            <p class="card-text">Interface moderna e responsiva usando Bootstrap 5</p>
                            <button class="btn btn-danger" disabled>Ativo</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-tachometer-alt fa-3x text-secondary"></i>
                            </div>
                            <h5 class="card-title">Performance</h5>
                            <p class="card-text">Otimizado para alta performance com cache e otimizações</p>
                            <button class="btn btn-secondary" disabled>Otimizado</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-server"></i> Informações do Servidor</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>🚀 Framework & Linguagem</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Laravel:</strong> {{ app()->version() }}</li>
                                        <li><strong>PHP:</strong> {{ PHP_VERSION }}</li>
                                        <li><strong>Sistema:</strong> {{ PHP_OS }}</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>🖥️ Servidor & Ambiente</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Servidor:</strong> {{ $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido' }}</li>
                                        <li><strong>Timezone:</strong> {{ date_default_timezone_get() }}</li>
                                        <li><strong>Data/Hora:</strong> {{ date('d/m/Y H:i:s') }}</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-12">
                                    <h6>📦 Extensões Oracle</h6>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge {{ extension_loaded('oci8') ? 'bg-success' : 'bg-secondary' }}">
                                            <i class="fas {{ extension_loaded('oci8') ? 'fa-check' : 'fa-times' }}"></i>
                                            OCI8
                                        </span>
                                        <span class="badge {{ extension_loaded('pdo_oci') ? 'bg-success' : 'bg-secondary' }}">
                                            <i class="fas {{ extension_loaded('pdo_oci') ? 'fa-check' : 'fa-times' }}"></i>
                                            PDO_OCI
                                        </span>
                                        <span class="badge {{ extension_loaded('mbstring') ? 'bg-success' : 'bg-secondary' }}">
                                            <i class="fas {{ extension_loaded('mbstring') ? 'fa-check' : 'fa-times' }}"></i>
                                            MBString
                                        </span>
                                        <span class="badge {{ extension_loaded('curl') ? 'bg-success' : 'bg-secondary' }}">
                                            <i class="fas {{ extension_loaded('curl') ? 'fa-check' : 'fa-times' }}"></i>
                                            cURL
                                        </span>
                                        <span class="badge {{ extension_loaded('openssl') ? 'bg-success' : 'bg-secondary' }}">
                                            <i class="fas {{ extension_loaded('openssl') ? 'fa-check' : 'fa-times' }}"></i>
                                            OpenSSL
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0">
                        &copy; 2024 <strong>Salesforce Laravel</strong> - Sistema de Análise de Mercado
                    </p>
                    <small class="text-muted">
                        Desenvolvido com Laravel {{ app()->version() }} e PHP {{ PHP_VERSION }}
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>