<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoInventario extends Model
{
    protected $fillable = [
        'clave_operacion',
        'variante_materia_prima_id',
        'registrado_por',
        'tipo',
        'cantidad',
        'existencia_anterior',
        'existencia_posterior',
        'costo_unitario',
        'referencia_tipo',
        'referencia_id',
        'observaciones',
        'fecha_movimiento',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'existencia_anterior' => 'decimal:3',
            'existencia_posterior' => 'decimal:3',
            'costo_unitario' => 'decimal:4',
            'fecha_movimiento' => 'datetime',
        ];
    }

    public function varianteMateriaPrima(): BelongsTo
    {
        return $this->belongsTo(VarianteMateriaPrima::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
