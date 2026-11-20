
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_cotizaciones', function (Blueprint $table) {
            $table->id();

            // Cotización correspondiente.
            $table->foreignId('cotizacion_id')
                ->constrained('cotizaciones')
                ->restrictOnDelete();

            // Variante del producto cotizado.
            $table->foreignId('variante_producto_id')
                ->constrained('variantes_productos')
                ->restrictOnDelete();

            // Cantidad solicitada.
            $table->unsignedInteger('cantidad');

            // Precio ofrecido al cliente.
            $table->decimal('precio_unitario', 12, 2);

            // Descuento aplicado a esta partida.
            $table->decimal('descuento', 12, 2)->default(0);

            // Importe total de la partida.
            $table->decimal('subtotal', 12, 2);

            // Individual o mayoreo.
            $table->string('tipo_precio', 20)->default('individual');

            // Información específica de personalización.
            $table->text('especificaciones')->nullable();

            $table->timestamps();

            $table->index('cotizacion_id');
            $table->index('variante_producto_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_cotizaciones');
    }
};
