
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_producciones', function (Blueprint $table) {
            $table->id();

            // Producción a la que pertenece.
            $table->foreignId('produccion_id')
                ->constrained('producciones')
                ->restrictOnDelete();

            // Variante del producto personalizado obtenido.
            $table->foreignId('variante_producto_id')
                ->constrained('variantes_productos')
                ->restrictOnDelete();

            // Cantidad de unidades producidas.
            $table->unsignedInteger('cantidad');

            // Costos históricos de fabricación.
            $table->decimal('costo_unitario', 12, 2);
            $table->decimal('costo_total', 12, 2);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Evitar repetir una variante en la misma producción.
            $table->unique(
                ['produccion_id', 'variante_producto_id'],
                'produccion_variante_unica'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_producciones');
    }
};
