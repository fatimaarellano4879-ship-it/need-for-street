<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompraMateriaPrima extends Model
{
    protected $table = 'detalles_compras_materias_primas';

    protected $fillable = [
        'compra_id',
        'variante_materia_prima_id',
        'pedido_id',
        'cantidad',
        'costo_unitario',
        'subtotal',
        'bajo_pedido',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'costo_unitario' => 'decimal:4',
            'subtotal' => 'decimal:2',
            'bajo_pedido' => 'boolean',
        ];
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(CompraMateriaPrima::class, 'compra_id');
    }

    public function varianteMateriaPrima(): BelongsTo
    {
        return $this->belongsTo(VarianteMateriaPrima::class);
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class);
    }
}
