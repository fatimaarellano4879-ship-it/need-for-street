<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleVenta extends Model
{
    protected $fillable = [
        'venta_id',
        'variante_producto_id',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal',
        'costo_unitario',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
            'descuento' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'costo_unitario' => 'decimal:2',
        ];
    }

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class);
    }

    public function varianteProducto(): BelongsTo
    {
        return $this->belongsTo(VarianteProducto::class);
    }
}
