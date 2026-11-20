
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_pedidos', function (Blueprint $table) {
            $table->id();

            // Pedido correspondiente.
            $table->foreignId('pedido_id')
                ->constrained('pedidos')
                ->restrictOnDelete();

            // Variante del producto solicitado.
            $table->foreignId('variante_producto_id')
                ->constrained('variantes_productos')
                ->restrictOnDelete();

            // Cantidad solicitada.
            $table->unsignedInteger('cantidad');

            // Precio acordado con el cliente.
            $table->decimal('precio_unitario', 12, 2);

            // Descuento de esta partida.
            $table->decimal('descuento', 12, 2)->default(0);

            // Importe de la partida.
            $table->decimal('subtotal', 12, 2);

            // Individual o mayoreo.
            $table->string('tipo_precio', 20)->default('individual');

            // Indicaciones específicas de personalización.
            $table->text('especificaciones')->nullable();

            $table->timestamps();

            $table->index('pedido_id');
            $table->index('variante_producto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_pedidos');
    }
};
