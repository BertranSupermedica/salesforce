<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BASE ANVISA - Salesforce Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section { 
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%); 
            color: white; 
        }
        .search-card { 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            border: none; 
        }
        .table-hover tbody tr:hover { 
            background-color: #f8f9fa; 
        }
        .stat-card { 
            transition: transform 0.2s; 
        }
        .stat-card:hover { 
            transform: translateY(-2px); 
        }
        .cnpj-formatted { 
            font-family: monospace; 
            font-size: 0.9em; 
        }
        .ean-code { 
            font-family: monospace; 
            font-size: 0.8em; 
            background: #f8f9fa; 
            padding: 2px 4px; 
            border-radius: 3px; 
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
                <a class="nav-link active" href="/base-anvisa">BASE ANVISA</a>
            </div>
        </div>
    </nav>

    <div class="hero-section py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 mb-2">
                        <i class="fas fa-database"></i> BASE ANVISA
                    </h1>
                    <p class="lead mb-0">Sistema de consulta da base de dados da ANVISA</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-flex gap-2 justify-content-end">
                        @if(!empty($searchCriteria))
                        <a href="{{ route('base-anvisa.export', $searchCriteria) }}" 
                           class="btn btn-light">
                            <i class="fas fa-download"></i> Exportar CSV
                        </a>
                        @endif
                        <a href="/api/base-anvisa/statistics" target="_blank" 
                           class="btn btn-outline-light">
                            <i class="fas fa-chart-bar"></i> API Stats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-4">
        @if(isset($error))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Estatísticas -->
        @if(!empty($statistics))
        <div class="row mb-4">
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="card stat-card bg-primary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-list fa-2x mb-2"></i>
                        <h5 class="card-title">{{ number_format($statistics['total_registros'] ?? 0) }}</h5>
                        <small>Total Registros</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="card stat-card bg-success text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-industry fa-2x mb-2"></i>
                        <h5 class="card-title">{{ number_format($statistics['total_laboratorios'] ?? 0) }}</h5>
                        <small>Laboratórios</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="card stat-card bg-info text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-pills fa-2x mb-2"></i>
                        <h5 class="card-title">{{ number_format($statistics['total_produtos'] ?? 0) }}</h5>
                        <small>Produtos</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="card stat-card bg-warning text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-barcode fa-2x mb-2"></i>
                        <h5 class="card-title">{{ number_format($statistics['registros_com_ean1'] ?? 0) }}</h5>
                        <small>Com EAN 1</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="card stat-card bg-secondary text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-barcode fa-2x mb-2"></i>
                        <h5 class="card-title">{{ number_format($statistics['registros_com_ean2'] ?? 0) }}</h5>
                        <small>Com EAN 2</small>
                    </div>
                </div>
            </div>
            <div class="col-md-2 col-sm-6 mb-2">
                <div class="card stat-card bg-dark text-white">
                    <div class="card-body text-center">
                        <i class="fas fa-barcode fa-2x mb-2"></i>
                        <h5 class="card-title">{{ number_format($statistics['registros_com_ean3'] ?? 0) }}</h5>
                        <small>Com EAN 3</small>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Formulário de Busca -->
        <div class="card search-card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-search"></i> Filtros de Busca
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('base-anvisa.index') }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="cnpj" 
                                   name="cnpj" 
                                   value="{{ $searchCriteria['cnpj'] ?? '' }}"
                                   placeholder="00.000.000/0000-00">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="laboratorio" class="form-label">Laboratório</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="laboratorio" 
                                   name="laboratorio" 
                                   value="{{ $searchCriteria['laboratorio'] ?? '' }}"
                                   placeholder="Nome do laboratório">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="produto" class="form-label">Produto</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="produto" 
                                   name="produto" 
                                   value="{{ $searchCriteria['produto'] ?? '' }}"
                                   placeholder="Nome do produto">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="registro" class="form-label">Registro</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="registro" 
                                   name="registro" 
                                   value="{{ $searchCriteria['registro'] ?? '' }}"
                                   placeholder="Número do registro">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="ean" class="form-label">Código EAN</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="ean" 
                                   name="ean" 
                                   value="{{ $searchCriteria['ean'] ?? '' }}"
                                   placeholder="Código de barras EAN">
                        </div>
                        <div class="col-md-9 mb-3 d-flex align-items-end">
                            <div class="btn-group w-100" role="group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                                <a href="{{ route('base-anvisa.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Resultados -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-table"></i> 
                    Resultados 
                    @if(isset($registros) && $registros->total() > 0)
                        <span class="badge bg-primary">{{ number_format($registros->total()) }}</span>
                    @endif
                </h5>
                @if(isset($registros) && $registros->hasPages())
                <div class="pagination-info">
                    <small class="text-muted">
                        Página {{ $registros->currentPage() }} de {{ $registros->lastPage() }}
                        ({{ $registros->firstItem() ?? 0 }}-{{ $registros->lastItem() ?? 0 }} de {{ $registros->total() }})
                    </small>
                </div>
                @endif
            </div>
            <div class="card-body">
                @if(isset($registros) && $registros->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>CNPJ</th>
                                <th>Laboratório</th>
                                <th>Código GGREM</th>
                                <th>Registro</th>
                                <th>Produto</th>
                                <th>Apresentação</th>
                                <th>Códigos EAN</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registros as $registro)
                            <tr>
                                <td>
                                    <span class="cnpj-formatted">{{ $registro->formatted_cnpj }}</span>
                                </td>
                                <td>
                                    <strong>{{ $registro->LABORATORIO }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $registro->CODIGO_GGREM }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $registro->REGISTRO }}</span>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="{{ $registro->PRODUTO }}">
                                        {{ $registro->PRODUTO }}
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $registro->APRESENTACAO }}</small>
                                </td>
                                <td>
                                    @if($registro->EAN_1)
                                        <div><span class="ean-code">{{ $registro->EAN_1 }}</span></div>
                                    @endif
                                    @if($registro->EAN_2)
                                        <div><span class="ean-code">{{ $registro->EAN_2 }}</span></div>
                                    @endif
                                    @if($registro->EAN_3)
                                        <div><span class="ean-code">{{ $registro->EAN_3 }}</span></div>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('base-anvisa.show', ['registro' => $registro->REGISTRO]) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                @if($registros->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $registros->appends(request()->query())->links() }}
                </div>
                @endif

                @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum registro encontrado</h5>
                    <p class="text-muted">
                        @if(empty($searchCriteria))
                            Use os filtros acima para buscar registros na base ANVISA
                        @else
                            Tente ajustar os filtros de busca
                        @endif
                    </p>
                    @if(!empty($searchCriteria))
                    <a href="{{ route('base-anvisa.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-times"></i> Limpar Filtros
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Top Laboratórios -->
        @if(!empty($topLaboratories) && count($topLaboratories) > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-trophy"></i> Top Laboratórios por Número de Produtos
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(array_slice($topLaboratories, 0, 5) as $index => $lab)
                    <div class="col-md-2 col-sm-6 mb-3">
                        <div class="card h-100 text-center">
                            <div class="card-body">
                                <div class="mb-2">
                                    @if($index == 0)
                                        <i class="fas fa-trophy text-warning fa-2x"></i>
                                    @elseif($index == 1)
                                        <i class="fas fa-medal text-secondary fa-2x"></i>
                                    @elseif($index == 2)
                                        <i class="fas fa-award text-warning fa-2x"></i>
                                    @else
                                        <i class="fas fa-star text-primary fa-2x"></i>
                                    @endif
                                </div>
                                <h6 class="card-title text-truncate" title="{{ $lab['LABORATORIO'] }}">
                                    {{ $lab['LABORATORIO'] }}
                                </h6>
                                <p class="card-text">
                                    <strong>{{ number_format($lab['total_produtos']) }}</strong><br>
                                    <small class="text-muted">produtos</small>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
        // Máscara para CNPJ
        document.getElementById('cnpj').addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 14) {
                value = value.replace(/^(\d{2})(\d)/, '$1.$2');
                value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });
    </script>
</body>
</html>