<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetallePedido extends Model
{
    protected $fillable = [
        'pedido_id',
        'variante_producto_id',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal',
        'tipo_precio',
        'especificaciones',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
            'descuento' => 'decimal:2',
            'subtotal' => 'decimal:2',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function varianteProducto(): BelongsTo
    {
        return $this->belongsTo(VarianteProducto::class);
    }
}
