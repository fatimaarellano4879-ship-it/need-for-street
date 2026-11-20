
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalles_compras_materias_primas', function (Blueprint $table) {
            $table->foreignId('pedido_id')
                ->nullable()
                ->constrained('pedidos')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('detalles_compras_materias_primas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pedido_id');
        });
    }
};
