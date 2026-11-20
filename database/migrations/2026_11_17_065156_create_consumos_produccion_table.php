<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumos_produccion', function (Blueprint $table) {
            $table->id();

            // Partida de producción correspondiente.
            $table->foreignId('detalle_produccion_id')
                ->constrained('detalles_producciones')
                ->restrictOnDelete();

            // Materia prima física utilizada.
            // Nula cuando el consumo corresponde a impresión.
            $table->foreignId('variante_materia_prima_id')
                ->nullable()
                ->constrained('variantes_materias_primas')
                ->restrictOnDelete();

            // Aplicación de impresión utilizada.
            // Nula cuando el consumo es material físico.
            $table->foreignId('detalle_impresion_id')
                ->nullable()
                ->constrained('detalles_impresion')
                ->restrictOnDelete();

            // Cantidad realmente consumida.
            $table->decimal('cantidad', 12, 3);

            // pieza, metro, cm2, etc.
            $table->string('unidad_medida', 30);

            // Copia histórica de los costos.
            $table->decimal('costo_unitario', 12, 4);
            $table->decimal('costo_total', 12, 2);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index('detalle_produccion_id');
            $table->index('variante_materia_prima_id');
            $table->index('detalle_impresion_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumos_produccion');
    }
};
