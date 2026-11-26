<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            // Qué cupón se usó (null = pedido sin cupón)
            $table->foreignId('cupon_id')->nullable()->after('costo_delivery')
                ->constrained('cupones')->restrictOnDelete();

            // Cuánto se descontó, en soles (queda fijo aunque luego cambien el cupón)
            $table->decimal('descuento', 8, 2)->default(0)->after('cupon_id');
        });
    }

    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cupon_id');
            $table->dropColumn('descuento');
        });
    }
};