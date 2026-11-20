<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumoProduccion extends Model
{
    protected $fillable = [
        'detalle_produccion_id',
        'variante_materia_prima_id',
        'cantidad',
        'unidad_medida',
        'costo_unitario',
        'costo_total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'costo_unitario' => 'decimal:4',
            'costo_total' => 'decimal:2',
        ];
    }

    public function detalleProduccion(): BelongsTo
    {
        return $this->belongsTo(
            DetalleProduccion::class,
            'detalle_produccion_id'
        );
    }

    public function varianteMateriaPrima(): BelongsTo
    {
        return $this->belongsTo(VarianteMateriaPrima::class);
    }
}
