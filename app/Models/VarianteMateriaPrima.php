<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VarianteMateriaPrima extends Model
{
    protected $fillable = [
        'materia_prima_id',
        'talla_id',
        'color_id',
        'corte',
        'atributos',
        'sku',
        'clave_variante',
        'modo_abastecimiento',
        'stock_actual',
        'stock_minimo',
        'costo_promedio',
        'costo_ultima_compra',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'atributos' => 'array',
            'stock_actual' => 'decimal:3',
            'stock_minimo' => 'decimal:3',
            'costo_promedio' => 'decimal:4',
            'costo_ultima_compra' => 'decimal:4',
            'activo' => 'boolean',
        ];
    }

    public function materiaPrima(): BelongsTo
    {
        return $this->belongsTo(MateriaPrima::class);
    }

    public function talla(): BelongsTo
    {
        return $this->belongsTo(Talla::class);
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(MovimientoInventario::class);
    }
}
