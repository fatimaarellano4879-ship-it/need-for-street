
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();

            // Folio único del pedido.
            $table->string('folio', 50)->unique();

            // Cliente obligatorio.
            $table->foreignId('cliente_id')
                ->constrained('clientes')
                ->restrictOnDelete();

            // Cotización de origen, si existe.
            $table->foreignId('cotizacion_id')
                ->nullable()
                ->unique()
                ->constrained('cotizaciones')
                ->restrictOnDelete();

            // Usuario responsable.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Estado del pedido.
            // pendiente, confirmado, en_produccion,
            // listo, entregado, cancelado.
            $table->string('estado', 30)->default('pendiente');

            // Fechas de control.
            $table->dateTime('fecha_pedido');
            $table->dateTime('fecha_entrega_estimada')->nullable();
            $table->dateTime('fecha_entrega_real')->nullable();

            // Importes históricos.
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['cliente_id', 'estado']);
            $table->index('fecha_pedido');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
