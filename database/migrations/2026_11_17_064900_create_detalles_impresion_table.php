<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_impresion', function (Blueprint $table) {
            $table->id();

            // Aplicación utilizada en una partida de producción.
            $table->foreignId('detalle_produccion_id')
                ->constrained('detalles_producciones')
                ->restrictOnDelete();

            // Trabajo de impresión del proveedor.
            $table->foreignId('trabajo_impresion_id')
                ->constrained('trabajos_impresion')
                ->restrictOnDelete();

            // Ubicación del estampado.
            $table->string('ubicacion', 100)->nullable();

            // Dimensiones de cada aplicación.
            $table->decimal('ancho_cm', 8, 2);
            $table->decimal('alto_cm', 8, 2);

            // Número de aplicaciones realmente utilizadas.
            $table->unsignedInteger('cantidad');

            // Superficie consumida.
            $table->decimal('superficie_unitaria_cm2', 12, 2);
            $table->decimal('superficie_total_cm2', 14, 2);

            // Automático o manual.
            $table->string('metodo_costeo', 20)->default('automatico');

            // Costo histórico de impresión.
            $table->decimal('costo_unitario', 12, 4);
            $table->decimal('costo_asignado', 12, 2);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index('detalle_produccion_id');
            $table->index('trabajo_impresion_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_impresion');
    }
};
