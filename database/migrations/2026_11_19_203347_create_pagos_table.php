<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            // Pedido al que corresponde el anticipo o abono.
            $table->foreignId('pedido_id')
                ->nullable()
                ->constrained('pedidos')
                ->restrictOnDelete();

            // Venta a la que corresponde el pago.
            $table->foreignId('venta_id')
                ->nullable()
                ->constrained('ventas')
                ->restrictOnDelete();

            // Usuario que registró el pago.
            $table->foreignId('registrado_por')
                ->constrained('users')
                ->restrictOnDelete();

            // efectivo, terminal o transferencia.
            $table->string('metodo_pago', 20);

            // Importe recibido.
            $table->decimal('monto', 12, 2);

            // confirmado o cancelado.
            $table->string('estado', 20)->default('confirmado');

            $table->dateTime('fecha_pago');

            // Referencia bancaria o de terminal.
            $table->string('referencia', 100)->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['pedido_id', 'estado']);
            $table->index(['venta_id', 'estado']);
            $table->index('fecha_pago');
            $table->index('metodo_pago');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
