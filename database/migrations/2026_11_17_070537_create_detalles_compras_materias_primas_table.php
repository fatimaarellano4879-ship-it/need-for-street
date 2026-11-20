
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detalles_compras_materias_primas', function (Blueprint $table) {
            $table->id();

            // Compra correspondiente.
            $table->foreignId('compra_id')
                ->constrained('compras_materias_primas')
                ->restrictOnDelete();

            // Variante de materia prima adquirida.
            $table->foreignId('variante_materia_prima_id')
                ->constrained('variantes_materias_primas')
                ->restrictOnDelete();

            // Cantidad adquirida.
            $table->decimal('cantidad', 12, 3);

            // Costos de adquisición.
            $table->decimal('costo_unitario', 12, 4);
            $table->decimal('subtotal', 12, 2);

            // Indica si el material se adquirió para un pedido específico.
            $table->boolean('bajo_pedido')->default(false);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index('variante_materia_prima_id');
            $table->index('bajo_pedido');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detalles_compras_materias_primas');
    }
};
