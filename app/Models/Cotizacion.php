<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cotizacion extends Model
{
    protected $fillable = [
        'folio',
        'cliente_id',
        'registrado_por',
        'estado',
        'fecha_cotizacion',
        'fecha_vencimiento',
        'subtotal',
        'descuento',
        'total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_cotizacion' => 'datetime',
            'fecha_vencimiento' => 'datetime',
            'subtotal' => 'decimal:2',
            'descuento' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCotizacion::class);
    }

    public function pedido(): HasOne
    {
        return $this->hasOne(Pedido::class);
    }
}
