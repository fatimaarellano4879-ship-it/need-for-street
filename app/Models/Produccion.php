<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produccion extends Model
{
    protected $fillable = [
        'folio',
        'tipo',
        'pedido_id',
        'registrado_por',
        'estado',
        'fecha_produccion',
        'fecha_finalizacion',
        'costo_total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_produccion' => 'datetime',
            'fecha_finalizacion' => 'datetime',
            'costo_total' => 'decimal:2',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleProduccion::class);
    }
}
