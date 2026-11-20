
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('variantes_productos', function (Blueprint $table) {

            // Existencias actuales del producto terminado.
            $table->unsignedInteger('stock_actual')->default(0);

            // Cantidad mínima deseada.
            $table->unsignedInteger('stock_minimo')->default(0);

            // Determina si el producto controla existencias.
            $table->boolean('controla_inventario')->default(true);

        });
    }

    public function down(): void
    {
        Schema::table('variantes_productos', function (Blueprint $table) {
            $table->dropColumn([
                'stock_actual',
                'stock_minimo',
                'controla_inventario'
            ]);
        });
    }
};
