
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id();

            // Venta correspondiente.
            $table->foreignId('venta_id')
                ->constrained('ventas')
                ->restrictOnDelete();

            // Variante del producto vendido.
            $table->foreignId('variante_producto_id')
                ->constrained('variantes_productos')
                ->restrictOnDelete();

            // Cantidad vendida.
            $table->unsignedInteger('cantidad');

            // Precio histórico de venta.
            $table->decimal('precio_unitario', 12, 2);

            // Descuento aplicado a la partida.
            $table->decimal('descuento', 12, 2)->default(0);

            // Importe de la partida.
            $table->decimal('subtotal', 12, 2);

            // Costo histórico unitario al vender.
            $table->decimal('costo_unitario', 12, 2)->nullable();

            // Indicaciones de personalización, cuando corresponda.
            $table->text('especificaciones')->nullable();

            $table->timestamps();

            $table->index('venta_id');
            $table->index('variante_producto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_ventas');
    }
};
