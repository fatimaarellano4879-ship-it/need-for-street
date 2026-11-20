
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('producciones', function (Blueprint $table) {
            $table->id();

            // Identificador de la producción.
            $table->string('folio', 50)->unique();

            // stock o pedido.
            $table->string('tipo', 20);

            // Usuario responsable de la producción.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Estado de la producción.
            $table->string('estado', 20)->default('pendiente');

            // Fechas de control.
            $table->dateTime('fecha_produccion');
            $table->dateTime('fecha_finalizacion')->nullable();

            // Costos de elaboración.
            $table->decimal('costo_total', 12, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['tipo', 'estado']);
            $table->index('fecha_produccion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('producciones');
    }
};
