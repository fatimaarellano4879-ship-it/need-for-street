
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('precio');
        });
    }

    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio', 10, 2)->default(0);
        });

        $productos = DB::table('productos')->get();

        foreach ($productos as $producto) {
            $variante = DB::table('variantes_productos')
                ->where('producto_id', $producto->id)
                ->orderBy('id')
                ->first();

            if ($variante) {
                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update([
                        'precio' => $variante->precio_venta,
                    ]);
            }
        }
    }
};
