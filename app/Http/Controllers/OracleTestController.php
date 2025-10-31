<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OracleTestController extends Controller
{
    /**
     * Display the Oracle connection test page
     */
    public function index()
    {
        $testResults = $this->testOracleConnections();
        
        return view('oracle-test', compact('testResults'));
    }

    /**
     * Test Oracle database connections
     */
    private function testOracleConnections(): array
    {
        $results = [];
        
        // Test main Oracle connection
        $results['oracle'] = $this->testConnection('oracle');
        
        // Test analise_mercado Oracle connection  
        $results['oracle_analise_mercado'] = $this->testConnection('oracle_analise_mercado');
        
        return $results;
    }
    
    /**
     * Test a specific database connection
     */
    private function testConnection(string $connection): array
    {
        $result = [
            'connection' => $connection,
            'status' => 'failed',
            'message' => '',
            'config' => [],
            'test_query' => null,
            'error' => null
        ];
        
        try {
            // Get connection config
            $config = config("database.connections.{$connection}");
            $result['config'] = [
                'host' => $config['host'] ?? 'N/A',
                'port' => $config['port'] ?? 'N/A',
                'database' => $config['database'] ?? 'N/A',
                'username' => $config['username'] ?? 'N/A'
            ];
            
            // Test connection
            $pdo = DB::connection($connection)->getPdo();
            
            if ($pdo) {
                $result['status'] = 'success';
                $result['message'] = 'Conexão estabelecida com sucesso!';
                
                // Execute test query
                $testQuery = DB::connection($connection)
                    ->select("SELECT USER as current_user, SYSDATE as current_date FROM DUAL");
                
                if (!empty($testQuery)) {
                    $result['test_query'] = $testQuery[0];
                }
            }
            
        } catch (Exception $e) {
            $result['status'] = 'failed';
            $result['message'] = 'Falha na conexão';
            $result['error'] = $e->getMessage();
        }
        
        return $result;
    }

    /**
     * API endpoint for Oracle connection test
     */
    public function apiTest(Request $request)
    {
        $connection = $request->get('connection', 'oracle');
        
        if (!in_array($connection, ['oracle', 'oracle_analise_mercado'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Conexão inválida'
            ], 400);
        }
        
        $result = $this->testConnection($connection);
        
        return response()->json($result);
    }

    /**
     * Show system information
     */
    public function systemInfo()
    {
        $info = [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido',
            'os' => PHP_OS,
            'extensions' => [
                'oci8' => extension_loaded('oci8'),
                'pdo_oci' => extension_loaded('pdo_oci'),
                'curl' => extension_loaded('curl'),
                'mbstring' => extension_loaded('mbstring'),
                'openssl' => extension_loaded('openssl'),
            ],
            'timezone' => date_default_timezone_get(),
            'current_time' => now()->format('d/m/Y H:i:s'),
        ];
        
        return response()->json($info);
    }
}