
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes_materias_primas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('materia_prima_id')
                ->constrained('materias_primas')
                ->restrictOnDelete();

            $table->foreignId('talla_id')
                ->nullable()
                ->constrained('tallas')
                ->restrictOnDelete();

            $table->foreignId('color_id')
                ->nullable()
                ->constrained('colores')
                ->restrictOnDelete();

            // Características adicionales.
            $table->string('corte', 50)->nullable();
            $table->json('atributos')->nullable();

            // Identificación única.
            $table->string('sku', 50)->unique();
            $table->string('clave_variante', 191)->unique();

            // Forma de abastecimiento.
            $table->string('modo_abastecimiento', 20)
                ->default('inventario');

            // Existencias.
            $table->decimal('stock_actual', 12, 3)->default(0);
            $table->decimal('stock_minimo', 12, 3)->default(0);

            // Costos de adquisición.
            $table->decimal('costo_promedio', 12, 4)->default(0);
            $table->decimal('costo_ultima_compra', 12, 4)->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->index(['materia_prima_id', 'activo']);
            $table->index('modo_abastecimiento');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variantes_materias_primas');
    }
};
