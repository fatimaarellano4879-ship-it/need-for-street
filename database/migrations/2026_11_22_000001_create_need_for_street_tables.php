<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();          // id del HTML: u-1, u-1732...
            $t->string('name');
            $t->string('alias')->index();
            $t->string('pin', 4);
            $t->string('role');                   // Administrador | Ventas / Mostrador | Producción / Taller
            $t->boolean('active')->default(true);
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        Schema::create('palette_colors', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();          // = nombre del color
            $t->string('name');
            $t->string('hex', 7);
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        Schema::create('raw_materials', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();
            $t->string('name');
            $t->string('category');
            $t->string('sub_type')->nullable();
            $t->string('color')->default('N/A');
            $t->string('size_or_measure');
            $t->integer('qty')->default(0);
            $t->decimal('cost', 10, 2)->default(0);
            $t->string('updated_by')->nullable();
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();
            $t->string('qr')->index();
            $t->string('name');
            $t->string('category');
            $t->string('color')->default('N/A');
            $t->string('size');
            $t->integer('stock')->default(0);
            $t->decimal('cost', 10, 2)->default(0);
            $t->decimal('price', 10, 2)->default(0);
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();
            $t->string('movement_date');
            $t->string('product');
            $t->string('qr');
            $t->string('type');
            $t->integer('delta');
            $t->string('user_name');
            $t->timestamps();
        });

        Schema::create('sales', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();
            $t->string('folio')->index();
            $t->string('sale_date');
            $t->string('user_name');
            $t->string('method');
            $t->json('split_details')->nullable();
            $t->decimal('gross_amount', 10, 2);
            $t->decimal('fee_amount', 10, 2)->default(0);
            $t->decimal('net_amount', 10, 2);
            $t->decimal('cost_amount', 10, 2)->default(0);
            $t->timestamps();
        });

        Schema::create('sale_items', function (Blueprint $t) {
            $t->id();
            $t->string('sale_uid')->index();
            $t->string('name');
            $t->string('category');
            $t->integer('qty');
            $t->decimal('price', 10, 2);
            $t->decimal('cost', 10, 2)->default(0);
            $t->timestamps();
        });

        Schema::create('custom_clients', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();
            $t->string('name');
            $t->string('phone');
            $t->text('notes')->nullable();
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        Schema::create('orders', function (Blueprint $t) {
            $t->id();
            $t->string('uid')->unique();
            $t->string('folio')->index();
            $t->string('order_date');
            $t->string('client_name');
            $t->string('client_phone');
            $t->text('summary');
            $t->decimal('total_amount', 10, 2);
            $t->decimal('advance_paid', 10, 2)->default(0);
            $t->string('prod_status')->default('Pendiente');
            $t->string('created_by')->nullable();
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });

        Schema::create('system_settings', function (Blueprint $t) {
            $t->string('key')->primary();         // terminal_fee_pct, quote_folio_counter, initialized
            $t->string('value');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['system_settings', 'orders', 'custom_clients', 'sale_items', 'sales',
                  'stock_movements', 'products', 'raw_materials', 'palette_colors', 'users'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};