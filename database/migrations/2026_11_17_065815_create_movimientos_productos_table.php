
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_productos', function (Blueprint $table) {
            $table->id();

            // Identificador único para evitar movimientos duplicados.
            $table->string('clave_operacion', 150)->unique()->nullable();

            // Variante del producto terminado.
            $table->foreignId('variante_producto_id')
                ->constrained('variantes_productos')
                ->restrictOnDelete();

            // Usuario responsable.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // entrada, venta, salida, ajuste o devolucion.
            $table->string('tipo', 20);

            // Cantidad modificada.
            $table->unsignedInteger('cantidad');

            // Existencias antes y después.
            $table->unsignedInteger('existencia_anterior');
            $table->unsignedInteger('existencia_posterior');

            // Costo histórico del producto.
            $table->decimal('costo_unitario', 12, 2)->nullable();

            // Referencia a producción, venta o devolución.
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();

            $table->text('observaciones')->nullable();

            $table->dateTime('fecha_movimiento');

            $table->timestamps();

            $table->index([
                'variante_producto_id',
                'fecha_movimiento'
            ]);

            $table->index(['tipo', 'fecha_movimiento']);

            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_productos');
    }
};
