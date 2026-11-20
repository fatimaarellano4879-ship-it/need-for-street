
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias_primas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100);

            // Tipo de producto base que se compra.
            $table->string('categoria', 50);

            // Por ejemplo: pieza.
            $table->string('unidad_medida', 30)->default('pieza');

            $table->decimal('ancho_cm', 8, 2)->nullable();

            $table->text('descripcion')->nullable();

            $table->boolean('controla_inventario')->default(true);

            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->index('categoria');
            $table->index('activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias_primas');
    }
};
