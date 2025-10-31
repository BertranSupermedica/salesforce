<?php
/**
 * Salesforce - Página Inicial Welcome
 * Sistema de análise de mercado com Laravel e Oracle
 */
?>
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
            min-height: 100vh;
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
        .pulse { 
            animation: pulse 2s infinite; 
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-chart-line"></i> Salesforce Laravel
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="teste.php">Teste Config</a>
                <a class="nav-link" href="public/">Laravel App</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="pulse">
                        <h1 class="display-3 mb-4">
                            <i class="fas fa-rocket"></i><br>
                            Bem-vindo ao<br>
                            <span class="text-warning">Salesforce Laravel</span>
                        </h1>
                    </div>
                    <p class="lead mb-4">
                        Sistema moderno de análise de mercado integrado com Oracle Database na porta 411.
                        Consulte a BASE ANVISA e gerencie dados farmacêuticos.
                    </p>
                    <div class="mb-4">
                        <span class="badge bg-success status-badge me-2">PHP <?= PHP_VERSION ?></span>
                        <span class="badge bg-info status-badge me-2">Oracle Ready</span>
                        <span class="badge bg-warning status-badge me-2">Bootstrap 5</span>
                        <span class="badge bg-light text-dark status-badge">Laravel Framework</span>
                    </div>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="public/" class="btn btn-warning btn-lg me-md-2">
                            <i class="fas fa-rocket"></i> Acessar Aplicação Laravel
                        </a>
                        <a href="teste.php" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-cog"></i> Testar Configuração
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-database fa-10x mb-4" style="opacity: 0.3;"></i>
                        <h3>Sistema Integrado</h3>
                        <p class="lead">
                            Conectado ao Oracle Database para consultas em tempo real
                            da base de dados da ANVISA.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-12">
                    <h2 class="display-5 mb-3">Funcionalidades do Sistema</h2>
                    <p class="lead text-muted">Explore as principais características da aplicação</p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-pills fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">BASE ANVISA</h5>
                            <p class="card-text">
                                Consulte e analise dados completos da base ANVISA com filtros avançados
                                e exportação para CSV.
                            </p>
                            <a href="public/base-anvisa" class="btn btn-primary">Acessar BASE</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-database fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">Oracle Database</h5>
                            <p class="card-text">
                                Conexão nativa com Oracle na porta 411 usando OCI8. 
                                Consultas otimizadas e seguras.
                            </p>
                            <a href="public/oracle-test" class="btn btn-success">Testar Conexão</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-chart-bar fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">Análise de Mercado</h5>
                            <p class="card-text">
                                Estatísticas em tempo real, rankings de laboratórios
                                e análises detalhadas dos produtos.
                            </p>
                            <a href="public/base-anvisa" class="btn btn-warning">Ver Estatísticas</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-search fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">Busca Avançada</h5>
                            <p class="card-text">
                                Filtre por CNPJ, laboratório, produto, registro
                                e códigos EAN com paginação automática.
                            </p>
                            <a href="public/base-anvisa" class="btn btn-info">Pesquisar</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-download fa-3x text-secondary"></i>
                            </div>
                            <h5 class="card-title">Exportação</h5>
                            <p class="card-text">
                                Exporte dados filtrados para CSV, imprima relatórios
                                ou copie informações para clipboard.
                            </p>
                            <a href="public/base-anvisa" class="btn btn-secondary">Exportar Dados</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-mobile-alt fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title">Responsivo</h5>
                            <p class="card-text">
                                Interface moderna e responsiva que funciona
                                perfeitamente em desktop, tablet e mobile.
                            </p>
                            <span class="btn btn-danger disabled">Design Moderno</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-info-circle"></i> Informações do Sistema
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>🚀 Tecnologias</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>PHP:</strong> <?= PHP_VERSION ?></li>
                                        <li><strong>Framework:</strong> Laravel 10</li>
                                        <li><strong>Database:</strong> Oracle 11g/19c</li>
                                        <li><strong>Frontend:</strong> Bootstrap 5 + FontAwesome</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h6>🔧 Status do Sistema</h6>
                                    <ul class="list-unstyled">
                                        <li><strong>Servidor:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Apache/Nginx' ?></li>
                                        <li><strong>Timezone:</strong> <?= date_default_timezone_get() ?></li>
                                        <li><strong>Data/Hora:</strong> <?= date('d/m/Y H:i:s') ?></li>
                                        <li><strong>Status:</strong> <span class="badge bg-success">Online</span></li>
                                    </ul>
                                </div>
                            </div>
                            
                            <hr>
                            
                            <div class="row">
                                <div class="col-12">
                                    <h6>📦 Extensões PHP</h6>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php
                                        $extensions = ['oci8', 'pdo_oci', 'mbstring', 'curl', 'openssl', 'json'];
                                        foreach ($extensions as $ext) {
                                            $loaded = extension_loaded($ext);
                                            echo '<span class="badge ' . ($loaded ? 'bg-success' : 'bg-secondary') . '">';
                                            echo '<i class="fas ' . ($loaded ? 'fa-check' : 'fa-times') . '"></i> ' . $ext;
                                            echo '</span> ';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-primary text-white">
        <div class="container text-center">
            <h3>🎯 Pronto para começar?</h3>
            <p class="lead mb-4">
                Explore a base de dados da ANVISA e realize análises detalhadas de mercado farmacêutico.
            </p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                <a href="public/" class="btn btn-warning btn-lg me-md-2">
                    <i class="fas fa-rocket"></i> Acessar Sistema Laravel
                </a>
                <a href="teste.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-cog"></i> Verificar Config
                </a>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="mb-2">
                        &copy; <?= date('Y') ?> <strong>Salesforce Laravel</strong> - Sistema de Análise de Mercado
                    </p>
                    <small class="text-muted">
                        Desenvolvido com Laravel Framework e Oracle Database | Porta 411
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>