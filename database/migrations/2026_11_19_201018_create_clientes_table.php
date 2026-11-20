
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            // Tipo de cliente: individual o mayorista.
            $table->string('tipo_cliente', 20)->default('individual');

            // Datos personales o de contacto.
            $table->string('nombre', 100);
            $table->string('apellidos', 100)->nullable();

            // Datos comerciales, cuando corresponda.
            $table->string('razon_social', 150)->nullable();
            $table->string('rfc', 13)->nullable();

            // Información de contacto.
            $table->string('telefono', 20)->nullable();
            $table->string('correo_electronico', 150)->nullable();

            // Dirección opcional.
            $table->text('direccion')->nullable();

            // Usuario que registró al cliente.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Estado del cliente.
            $table->boolean('activo')->default(true);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index('tipo_cliente');
            $table->index('activo');
            $table->index('telefono');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
