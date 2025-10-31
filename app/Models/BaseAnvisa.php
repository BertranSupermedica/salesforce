<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseAnvisa extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'BASE_ANVISA';

    /**
     * The connection name for the model.
     *
     * @var string
     */
    protected $connection = 'oracle_analise_mercado';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = null;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'CNPJ',
        'LABORATORIO', 
        'CODIGO_GGREM',
        'REGISTRO',
        'EAN_1',
        'EAN_2', 
        'EAN_3',
        'PRODUTO',
        'APRESENTACAO'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'CNPJ' => 'string',
        'LABORATORIO' => 'string',
        'CODIGO_GGREM' => 'string',
        'REGISTRO' => 'string',
        'EAN_1' => 'string',
        'EAN_2' => 'string',
        'EAN_3' => 'string',
        'PRODUTO' => 'string',
        'APRESENTACAO' => 'string',
    ];

    /**
     * Get formatted CNPJ
     */
    public function getFormattedCnpjAttribute(): string
    {
        $cnpj = preg_replace('/\D/', '', $this->CNPJ ?? '');
        
        if (strlen($cnpj) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
        }
        
        return $this->CNPJ ?? '';
    }

    /**
     * Search by multiple criteria
     */
    public static function search(array $criteria, int $perPage = 15)
    {
        $query = self::query();

        if (!empty($criteria['cnpj'])) {
            $query->where('CNPJ', 'like', '%' . $criteria['cnpj'] . '%');
        }

        if (!empty($criteria['laboratorio'])) {
            $query->where('LABORATORIO', 'like', '%' . strtoupper($criteria['laboratorio']) . '%');
        }

        if (!empty($criteria['produto'])) {
            $query->where('PRODUTO', 'like', '%' . strtoupper($criteria['produto']) . '%');
        }

        if (!empty($criteria['registro'])) {
            $query->where('REGISTRO', 'like', '%' . $criteria['registro'] . '%');
        }

        if (!empty($criteria['ean'])) {
            $query->where(function($q) use ($criteria) {
                $q->where('EAN_1', 'like', '%' . $criteria['ean'] . '%')
                  ->orWhere('EAN_2', 'like', '%' . $criteria['ean'] . '%')
                  ->orWhere('EAN_3', 'like', '%' . $criteria['ean'] . '%');
            });
        }

        return $query->orderBy('LABORATORIO')
                    ->orderBy('PRODUTO')
                    ->paginate($perPage);
    }

    /**
     * Get statistics
     */
    public static function getStatistics(): array
    {
        return [
            'total_registros' => self::count(),
            'total_laboratorios' => self::distinct('LABORATORIO')->count('LABORATORIO'),
            'total_produtos' => self::distinct('PRODUTO')->count('PRODUTO'),
            'registros_com_ean1' => self::whereNotNull('EAN_1')->where('EAN_1', '!=', '')->count(),
            'registros_com_ean2' => self::whereNotNull('EAN_2')->where('EAN_2', '!=', '')->count(),
            'registros_com_ean3' => self::whereNotNull('EAN_3')->where('EAN_3', '!=', '')->count(),
        ];
    }

    /**
     * Get top laboratories by product count
     */
    public static function getTopLaboratories(int $limit = 10): array
    {
        return self::selectRaw('LABORATORIO, COUNT(*) as total_produtos')
                   ->whereNotNull('LABORATORIO')
                   ->where('LABORATORIO', '!=', '')
                   ->groupBy('LABORATORIO')
                   ->orderByDesc('total_produtos')
                   ->limit($limit)
                   ->get()
                   ->toArray();
    }
}