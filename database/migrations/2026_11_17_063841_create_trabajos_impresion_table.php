
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trabajos_impresion', function (Blueprint $table) {
            $table->id();

            // Identificación del trabajo.
            $table->string('folio', 50)->unique();

            // Proveedor que realizó la impresión.
            $table->string('proveedor_nombre', 150)->nullable();

            // Técnica utilizada.
            $table->string('tecnica', 20);

            // Dimensiones del material solicitado.
            $table->decimal('ancho_cm', 8, 2);
            $table->decimal('metros_lineales', 10, 3);

            // Superficie total solicitada.
            $table->decimal('superficie_total_cm2', 14, 2);

            // Costo total cobrado por el proveedor.
            $table->decimal('costo_total', 12, 2);

            // Estado del trabajo.
            $table->string('estado', 20)->default('solicitado');

            // Responsable del registro.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            $table->dateTime('fecha_solicitud');
            $table->dateTime('fecha_recepcion')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['tecnica', 'estado']);
            $table->index('fecha_solicitud');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trabajos_impresion');
    }
};
