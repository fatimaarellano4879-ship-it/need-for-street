<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VarianteProducto extends Model
{
    protected $fillable = [
        'producto_id',
        'talla_id',
        'color_id',
        'corte',
        'sku',
        'clave_combinacion',
        'precio_venta',
        'atributos',
        'activo',
        'stock_actual',
        'stock_minimo',
        'controla_inventario',
    ];

    protected function casts(): array
    {
        return [
            'precio_venta' => 'decimal:2',
            'atributos' => 'array',
            'activo' => 'boolean',
            'stock_actual' => 'integer',
            'stock_minimo' => 'integer',
            'controla_inventario' => 'boolean',
        ];
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function talla(): BelongsTo
    {
        return $this->belongsTo(Talla::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }
}
