<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleImpresion extends Model
{
    protected $fillable = [
        'trabajo_impresion_id',
        'ubicacion',
        'ancho_cm',
        'alto_cm',
        'cantidad',
        'superficie_unitaria_cm2',
        'superficie_total_cm2',
        'metodo_costeo',
        'costo_unitario',
        'costo_asignado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'ancho_cm' => 'decimal:2',
            'alto_cm' => 'decimal:2',
            'cantidad' => 'integer',
            'superficie_unitaria_cm2' => 'decimal:2',
            'superficie_total_cm2' => 'decimal:2',
            'costo_unitario' => 'decimal:4',
            'costo_asignado' => 'decimal:2',
        ];
    }

    public function trabajoImpresion(): BelongsTo
    {
        return $this->belongsTo(TrabajoImpresion::class);
    }
}
