
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();

            // Folio único.
            $table->string('folio', 50)->unique();

            // Cliente al que se presenta la cotización.
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->restrictOnDelete();

            // Usuario responsable.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // Estado de la cotización.
            // borrador, enviada, aceptada, rechazada, vencida.
            $table->string('estado', 20)->default('borrador');

            // Fechas de control.
            $table->dateTime('fecha_cotizacion');
            $table->dateTime('fecha_vencimiento')->nullable();

            // Importes.
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['cliente_id', 'estado']);
            $table->index('fecha_cotizacion');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};
