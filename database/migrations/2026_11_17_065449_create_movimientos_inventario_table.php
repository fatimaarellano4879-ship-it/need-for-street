
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();

            // Identificador Ãºnico para evitar movimientos duplicados.
            $table->string('clave_operacion', 150)->unique()->nullable();

            // Variante de materia prima afectada.
            $table->foreignId('variante_materia_prima_id')
                ->constrained('variantes_materias_primas')
                ->restrictOnDelete();

            // Usuario que realizÃ³ el movimiento.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Tipo de movimiento:
            // entrada, salida, consumo, ajuste o devolucion.
            $table->string('tipo', 20);

            // Cantidad modificada.
            $table->decimal('cantidad', 12, 3);

            // Existencias antes y despuÃ©s del movimiento.
            $table->decimal('existencia_anterior', 12, 3);
            $table->decimal('existencia_posterior', 12, 3);

            // Costo unitario al momento del movimiento.
            $table->decimal('costo_unitario', 12, 4)->nullable();

            // Referencia a compra, producciÃ³n o devoluciÃ³n.
            $table->string('referencia_tipo', 50)->nullable();
            $table->unsignedBigInteger('referencia_id')->nullable();

            $table->text('observaciones')->nullable();

            $table->dateTime('fecha_movimiento');

            $table->timestamps();

            $table->index(['variante_materia_prima_id', 'fecha_movimiento']);
            $table->index(['tipo', 'fecha_movimiento']);
            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
