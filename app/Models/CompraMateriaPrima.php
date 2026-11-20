<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompraMateriaPrima extends Model
{
    protected $table = 'compras_materias_primas';

    protected $fillable = [
        'folio',
        'proveedor_nombre',
        'registrado_por',
        'fecha_compra',
        'estado',
        'total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_compra' => 'datetime',
            'total' => 'decimal:2',
        ];
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCompraMateriaPrima::class, 'compra_id');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
