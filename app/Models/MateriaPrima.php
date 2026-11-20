<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MateriaPrima extends Model
{
    protected $fillable = [
        'nombre',
        'categoria',
        'unidad_medida',
        'ancho_cm',
        'descripcion',
        'controla_inventario',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'ancho_cm' => 'decimal:2',
            'controla_inventario' => 'boolean',
            'activo' => 'boolean',
        ];
    }

    public function variantes(): HasMany
    {
        return $this->hasMany(VarianteMateriaPrima::class);
    }
}
