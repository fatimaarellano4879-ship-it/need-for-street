<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoProducto extends Model
{
    protected $fillable = [
        'clave_operacion',
        'variante_producto_id',
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
            'cantidad' => 'integer',
            'existencia_anterior' => 'integer',
            'existencia_posterior' => 'integer',
            'costo_unitario' => 'decimal:2',
            'fecha_movimiento' => 'datetime',
        ];
    }

    public function varianteProducto(): BelongsTo
    {
        return $this->belongsTo(VarianteProducto::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
