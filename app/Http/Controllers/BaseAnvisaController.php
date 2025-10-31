<?php

namespace App\Http\Controllers;

use App\Models\BaseAnvisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class BaseAnvisaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            // Critérios de busca
            $searchCriteria = [
                'cnpj' => $request->get('cnpj'),
                'laboratorio' => $request->get('laboratorio'),
                'produto' => $request->get('produto'),
                'registro' => $request->get('registro'),
                'ean' => $request->get('ean'),
            ];

            // Filtrar critérios vazios
            $searchCriteria = array_filter($searchCriteria);

            // Buscar registros
            $registros = BaseAnvisa::search($searchCriteria, 20);

            // Estatísticas
            $statistics = BaseAnvisa::getStatistics();

            // Top laboratórios
            $topLaboratories = BaseAnvisa::getTopLaboratories(5);

            return view('base-anvisa.index', compact(
                'registros', 
                'statistics', 
                'topLaboratories', 
                'searchCriteria'
            ));

        } catch (Exception $e) {
            $errorMessage = 'Erro ao carregar dados da ANVISA: ' . $e->getMessage();
            
            return view('base-anvisa.index', [
                'registros' => collect()->paginate(20),
                'statistics' => [],
                'topLaboratories' => [],
                'searchCriteria' => [],
                'error' => $errorMessage
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(Request $request, $id = null)
    {
        try {
            if ($id) {
                // Buscar por ID específico se fornecido
                $registro = BaseAnvisa::where('REGISTRO', $id)->first();
                
                if (!$registro) {
                    return redirect()->route('base-anvisa.index')
                                   ->with('error', 'Registro não encontrado.');
                }
                
                return view('base-anvisa.show', compact('registro'));
            }

            // Mostrar detalhes baseado em critérios de busca
            $cnpj = $request->get('cnpj');
            $registro = $request->get('registro');

            $query = BaseAnvisa::query();

            if ($cnpj) {
                $query->where('CNPJ', $cnpj);
            }

            if ($registro) {
                $query->where('REGISTRO', $registro);
            }

            $registros = $query->limit(1)->get();

            if ($registros->isEmpty()) {
                return redirect()->route('base-anvisa.index')
                               ->with('error', 'Nenhum registro encontrado com os critérios fornecidos.');
            }

            return view('base-anvisa.show', ['registro' => $registros->first()]);

        } catch (Exception $e) {
            return redirect()->route('base-anvisa.index')
                           ->with('error', 'Erro ao carregar detalhes: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint for searching BASE_ANVISA
     */
    public function apiSearch(Request $request)
    {
        try {
            $searchCriteria = [
                'cnpj' => $request->get('cnpj'),
                'laboratorio' => $request->get('laboratorio'),
                'produto' => $request->get('produto'),
                'registro' => $request->get('registro'),
                'ean' => $request->get('ean'),
            ];

            $searchCriteria = array_filter($searchCriteria);
            $perPage = min($request->get('per_page', 15), 100); // Máximo 100 por página

            $registros = BaseAnvisa::search($searchCriteria, $perPage);

            return response()->json([
                'status' => 'success',
                'data' => $registros->items(),
                'pagination' => [
                    'current_page' => $registros->currentPage(),
                    'last_page' => $registros->lastPage(),
                    'per_page' => $registros->perPage(),
                    'total' => $registros->total(),
                    'from' => $registros->firstItem(),
                    'to' => $registros->lastItem(),
                ],
                'search_criteria' => $searchCriteria
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint for statistics
     */
    public function apiStatistics()
    {
        try {
            $statistics = BaseAnvisa::getStatistics();
            $topLaboratories = BaseAnvisa::getTopLaboratories(10);

            return response()->json([
                'status' => 'success',
                'statistics' => $statistics,
                'top_laboratories' => $topLaboratories
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export data to CSV
     */
    public function export(Request $request)
    {
        try {
            $searchCriteria = [
                'cnpj' => $request->get('cnpj'),
                'laboratorio' => $request->get('laboratorio'),
                'produto' => $request->get('produto'),
                'registro' => $request->get('registro'),
                'ean' => $request->get('ean'),
            ];

            $searchCriteria = array_filter($searchCriteria);

            // Buscar até 1000 registros para export
            $registros = BaseAnvisa::search($searchCriteria, 1000);

            $filename = 'base_anvisa_' . date('Y-m-d_H-i-s') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            return response()->stream(function() use ($registros) {
                $file = fopen('php://output', 'w');

                // BOM para UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // Cabeçalho CSV
                fputcsv($file, [
                    'CNPJ',
                    'Laboratório',
                    'Código GGREM',
                    'Registro',
                    'EAN 1',
                    'EAN 2',
                    'EAN 3',
                    'Produto',
                    'Apresentação'
                ], ';');

                // Dados
                foreach ($registros as $registro) {
                    fputcsv($file, [
                        $registro->CNPJ,
                        $registro->LABORATORIO,
                        $registro->CODIGO_GGREM,
                        $registro->REGISTRO,
                        $registro->EAN_1,
                        $registro->EAN_2,
                        $registro->EAN_3,
                        $registro->PRODUTO,
                        $registro->APRESENTACAO,
                    ], ';');
                }

                fclose($file);
            }, 200, $headers);

        } catch (Exception $e) {
            return redirect()->route('base-anvisa.index')
                           ->with('error', 'Erro ao exportar dados: ' . $e->getMessage());
        }
    }
}