<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Usuario autenticable de NEED FOR STREET.
 * El PIN se almacena únicamente como hash en pin_hash.
 */
class User extends Authenticatable
{
    protected $table = 'users';

    protected $guarded = [];

    protected $hidden = [
        'pin_hash',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function getAuthPassword(): string
    {
        return (string) $this->pin_hash;
    }

    public function getAuthPasswordName(): string
    {
        return 'pin_hash';
    }
}
