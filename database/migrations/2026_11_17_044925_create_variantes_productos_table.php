
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variantes_productos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('producto_id')
                ->constrained('productos')
                ->restrictOnDelete();

            $table->foreignId('talla_id')
                ->nullable()
                ->constrained('tallas')
                ->restrictOnDelete();

            $table->foreignId('color_id')
                ->nullable()
                ->constrained('colores')
                ->restrictOnDelete();

            // Características adicionales: corte, dimensiones, etc.
            $table->string('corte', 50)->nullable();

            $table->string('sku', 50)->unique();

            // Identificador único de la combinación comercial.
            $table->string('clave_combinacion', 191)->unique();

            $table->decimal('precio_venta', 10, 2);

            $table->json('atributos')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->index(['producto_id', 'talla_id', 'color_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('variantes_productos');
    }
};
