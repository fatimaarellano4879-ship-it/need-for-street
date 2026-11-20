
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras_materias_primas', function (Blueprint $table) {
            $table->id();

            // Folio único de compra.
            $table->string('folio', 50)->unique();

            // Nombre del proveedor.
            // Posteriormente se relacionará con el catálogo de proveedores.
            $table->string('proveedor_nombre', 150)->nullable();

            // Usuario que registró la compra.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Fecha de adquisición.
            $table->dateTime('fecha_compra');

            // Estado de la compra.
            $table->string('estado', 20)->default('registrada');

            // Importe total de la compra.
            $table->decimal('total', 12, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index('fecha_compra');
            $table->index('estado');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras_materias_primas');
    }
};
