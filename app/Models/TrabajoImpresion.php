<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrabajoImpresion extends Model
{
    protected $fillable = [
        'folio',
        'proveedor_nombre',
        'tecnica',
        'ancho_cm',
        'metros_lineales',
        'superficie_total_cm2',
        'costo_total',
        'estado',
        'registrado_por',
        'fecha_solicitud',
        'fecha_recepcion',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'ancho_cm' => 'decimal:2',
            'metros_lineales' => 'decimal:3',
            'superficie_total_cm2' => 'decimal:2',
            'costo_total' => 'decimal:2',
            'fecha_solicitud' => 'datetime',
            'fecha_recepcion' => 'datetime',
        ];
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleImpresion::class);
    }
}
