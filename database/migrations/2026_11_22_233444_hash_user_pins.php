<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Convierte los PIN de texto plano en hashes bcrypt y elimina la columna
     * que almacenaba el PIN original.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'pin_hash')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('pin_hash', 255)->nullable();
            });
        }

        if (Schema::hasColumn('users', 'pin')) {
            DB::table('users')
                ->select(['id', 'pin', 'pin_hash'])
                ->orderBy('id')
                ->chunkById(100, function ($users) {
                    foreach ($users as $user) {
                        if (! empty($user->pin_hash)) {
                            continue;
                        }

                        $plainPin = (string) $user->pin;

                        if (! preg_match('/^\d{4}$/', $plainPin)) {
                            throw new RuntimeException(
                                "El usuario con ID {$user->id} no tiene un PIN válido de cuatro dígitos. No se modificó su credencial."
                            );
                        }

                        DB::table('users')
                            ->where('id', $user->id)
                            ->update(['pin_hash' => Hash::make($plainPin)]);
                    }
                });

            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('pin');
            });
        }

        if (DB::table('users')->whereNull('pin_hash')->exists()) {
            throw new RuntimeException('Hay usuarios sin pin_hash. Revisa la migración antes de continuar.');
        }
    }

    /**
     * Los hashes no se pueden convertir de vuelta a los PIN originales.
     * Para revertir este cambio debe restaurarse una copia de seguridad anterior.
     */
    public function down(): void
    {
        throw new RuntimeException(
            'Esta migración de seguridad es irreversible: restaura el respaldo previo si necesitas volver al esquema anterior.'
        );
    }
};
