<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Talla extends Model
{
    protected $fillable = [
        'nombre',
        'orden',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'orden' => 'integer',
            'activo' => 'boolean',
        ];
    }

    public function variantes(): HasMany
    {
        return $this->hasMany(VarianteProducto::class);
    }
}
