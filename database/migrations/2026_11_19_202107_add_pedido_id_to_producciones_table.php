
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('producciones', function (Blueprint $table) {
            // Pedido al que pertenece la producción.
            // Será nulo cuando la producción sea para stock.
            $table->foreignId('pedido_id')
                ->nullable()
                ->after('tipo')
                ->constrained('pedidos')
                ->restrictOnDelete();

            $table->index('pedido_id');
        });
    }

    public function down(): void
    {
        Schema::table('producciones', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pedido_id');
        });
    }
};
