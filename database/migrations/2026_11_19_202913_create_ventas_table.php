
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            // Folio único de venta.
            $table->string('folio', 50)->unique();

            // Cliente opcional para ventas de mostrador.
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->restrictOnDelete();

            // Pedido relacionado, cuando corresponda.
            $table->foreignId('pedido_id')
                ->nullable()
                ->unique()
                ->constrained('pedidos')
                ->restrictOnDelete();

            // Usuario que registró la venta.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Mostrador o pedido.
            $table->string('tipo_venta', 20);

            // Estado de la venta.
            // registrada, pagada, parcial, cancelada.
            $table->string('estado', 20)->default('registrada');

            // Fechas.
            $table->dateTime('fecha_venta');

            // Importes.
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['cliente_id', 'fecha_venta']);
            $table->index(['tipo_venta', 'estado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
