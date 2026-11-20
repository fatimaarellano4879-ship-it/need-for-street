<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pedido extends Model
{
    protected $fillable = [
        'folio',
        'cliente_id',
        'cotizacion_id',
        'registrado_por',
        'estado',
        'fecha_pedido',
        'fecha_entrega_estimada',
        'fecha_entrega_real',
        'subtotal',
        'descuento',
        'total',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_pedido' => 'datetime',
            'fecha_entrega_estimada' => 'datetime',
            'fecha_entrega_real' => 'datetime',
            'subtotal' => 'decimal:2',
            'descuento' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cotizacion(): BelongsTo
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }

    public function producciones(): HasMany
    {
        return $this->hasMany(Produccion::class);
    }

    public function compras(): HasMany
    {
        return $this->hasMany(DetalleCompraMateriaPrima::class);
    }

    public function venta(): HasOne
    {
        return $this->hasOne(Venta::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}
