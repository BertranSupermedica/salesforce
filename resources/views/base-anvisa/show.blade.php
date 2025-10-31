<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto - BASE ANVISA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section { 
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%); 
            color: white; 
        }
        .detail-card { 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            border: none; 
        }
        .cnpj-formatted { 
            font-family: monospace; 
            font-size: 1.1em; 
        }
        .ean-code { 
            font-family: monospace; 
            font-size: 1em; 
            background: #f8f9fa; 
            padding: 8px 12px; 
            border-radius: 6px; 
            border: 2px dashed #dee2e6;
            display: inline-block;
            margin: 4px;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        .back-button {
            transition: all 0.3s;
        }
        .back-button:hover {
            transform: translateX(-5px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-pills"></i> Salesforce Laravel
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/oracle-test">Teste Oracle</a>
                <a class="nav-link" href="/base-anvisa">BASE ANVISA</a>
            </div>
        </div>
    </nav>

    <div class="hero-section py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 mb-2">
                        <i class="fas fa-info-circle"></i> Detalhes do Produto
                    </h1>
                    <p class="lead mb-0">Informações detalhadas do registro ANVISA</p>
                </div>
                <div class="col-md-4 text-end">
                    <a href="{{ route('base-anvisa.index') }}" class="btn btn-light back-button">
                        <i class="fas fa-arrow-left"></i> Voltar à Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        @if(isset($registro) && $registro)
        <div class="row">
            <!-- Informações Principais -->
            <div class="col-lg-8 mb-4">
                <div class="card detail-card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-pills"></i> Informações do Produto
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary mb-3">{{ $registro->PRODUTO }}</h4>
                                @if($registro->APRESENTACAO)
                                <p class="lead text-muted">{{ $registro->APRESENTACAO }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <span class="info-label">Registro ANVISA:</span><br>
                                <span class="badge bg-info fs-6">{{ $registro->REGISTRO }}</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <span class="info-label">Código GGREM:</span><br>
                                <span class="badge bg-secondary fs-6">{{ $registro->CODIGO_GGREM }}</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <span class="info-label">Laboratório:</span><br>
                                <h5 class="text-success">{{ $registro->LABORATORIO }}</h5>
                            </div>
                        </div>

                        @if($registro->CNPJ)
                        <div class="row">
                            <div class="col-12 mb-3">
                                <span class="info-label">CNPJ do Laboratório:</span><br>
                                <span class="cnpj-formatted fs-5">{{ $registro->formatted_cnpj }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Códigos EAN -->
            <div class="col-lg-4 mb-4">
                <div class="card detail-card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-barcode"></i> Códigos de Barras EAN
                        </h5>
                    </div>
                    <div class="card-body text-center">
                        @if($registro->EAN_1 || $registro->EAN_2 || $registro->EAN_3)
                            @if($registro->EAN_1)
                            <div class="mb-3">
                                <span class="info-label d-block mb-2">EAN 1:</span>
                                <span class="ean-code">{{ $registro->EAN_1 }}</span>
                            </div>
                            @endif

                            @if($registro->EAN_2)
                            <div class="mb-3">
                                <span class="info-label d-block mb-2">EAN 2:</span>
                                <span class="ean-code">{{ $registro->EAN_2 }}</span>
                            </div>
                            @endif

                            @if($registro->EAN_3)
                            <div class="mb-3">
                                <span class="info-label d-block mb-2">EAN 3:</span>
                                <span class="ean-code">{{ $registro->EAN_3 }}</span>
                            </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-ban fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Nenhum código EAN registrado</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Ações -->
                <div class="card detail-card mt-4">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0">
                            <i class="fas fa-cog"></i> Ações
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('base-anvisa.index', ['registro' => $registro->REGISTRO]) }}" 
                               class="btn btn-outline-primary">
                                <i class="fas fa-search"></i> Buscar por Registro
                            </a>
                            
                            <a href="{{ route('base-anvisa.index', ['laboratorio' => $registro->LABORATORIO]) }}" 
                               class="btn btn-outline-success">
                                <i class="fas fa-industry"></i> Produtos do Laboratório
                            </a>
                            
                            @if($registro->CNPJ)
                            <a href="{{ route('base-anvisa.index', ['cnpj' => $registro->CNPJ]) }}" 
                               class="btn btn-outline-info">
                                <i class="fas fa-building"></i> Produtos por CNPJ
                            </a>
                            @endif

                            <hr>

                            <button class="btn btn-outline-secondary" onclick="window.print()">
                                <i class="fas fa-print"></i> Imprimir
                            </button>

                            <button class="btn btn-outline-dark" onclick="copyToClipboard()">
                                <i class="fas fa-copy"></i> Copiar Dados
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações Técnicas -->
        <div class="row">
            <div class="col-12">
                <div class="card detail-card">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-database"></i> Informações Técnicas
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <td class="info-label">CNPJ:</td>
                                        <td>{{ $registro->CNPJ }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Laboratório:</td>
                                        <td>{{ $registro->LABORATORIO }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Código GGREM:</td>
                                        <td>{{ $registro->CODIGO_GGREM }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Registro:</td>
                                        <td>{{ $registro->REGISTRO }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm">
                                    <tr>
                                        <td class="info-label">EAN 1:</td>
                                        <td>{{ $registro->EAN_1 ?: 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">EAN 2:</td>
                                        <td>{{ $registro->EAN_2 ?: 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">EAN 3:</td>
                                        <td>{{ $registro->EAN_3 ?: 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Data Consulta:</td>
                                        <td>{{ date('d/m/Y H:i:s') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @else
        <!-- Erro - Registro não encontrado -->
        <div class="row">
            <div class="col-12">
                <div class="card detail-card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
                        <h3 class="text-muted mb-3">Registro não encontrado</h3>
                        <p class="text-muted mb-4">O produto solicitado não foi encontrado na base de dados da ANVISA.</p>
                        <a href="{{ route('base-anvisa.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Voltar à Lista
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p>&copy; 2024 Salesforce Laravel - BASE ANVISA</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyToClipboard() {
            @if(isset($registro) && $registro)
            const text = `
PRODUTO: {{ $registro->PRODUTO }}
APRESENTAÇÃO: {{ $registro->APRESENTACAO }}
LABORATÓRIO: {{ $registro->LABORATORIO }}
CNPJ: {{ $registro->CNPJ }}
REGISTRO: {{ $registro->REGISTRO }}
CÓDIGO GGREM: {{ $registro->CODIGO_GGREM }}
EAN 1: {{ $registro->EAN_1 }}
EAN 2: {{ $registro->EAN_2 }}
EAN 3: {{ $registro->EAN_3 }}
            `.trim();

            navigator.clipboard.writeText(text).then(() => {
                // Show success message
                const toast = document.createElement('div');
                toast.className = 'alert alert-success alert-dismissible fade show position-fixed';
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <i class="fas fa-check-circle"></i> Dados copiados para a área de transferência!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }).catch(err => {
                alert('Erro ao copiar dados: ' + err);
            });
            @endif
        }

        // Print styles
        const printStyles = `
            <style>
                @media print {
                    .navbar, footer, .btn, .card-header { display: none !important; }
                    .container { max-width: none !important; }
                    .card { border: 1px solid #000 !important; box-shadow: none !important; }
                    .ean-code { border: 1px solid #000 !important; }
                }
            </style>
        `;
        document.head.insertAdjacentHTML('beforeend', printStyles);
    </script>
</body>
</html>