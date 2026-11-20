<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetalleProduccion extends Model
{
    protected $fillable = [
        'produccion_id',
        'variante_producto_id',
        'cantidad',
        'costo_unitario',
        'costo_total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'costo_unitario' => 'decimal:2',
            'costo_total' => 'decimal:2',
        ];
    }

    public function produccion(): BelongsTo
    {
        return $this->belongsTo(Produccion::class);
    }

    public function varianteProducto(): BelongsTo
    {
        return $this->belongsTo(VarianteProducto::class);
    }

    public function consumos(): HasMany
    {
        return $this->hasMany(ConsumoProduccion::class);
    }
}
