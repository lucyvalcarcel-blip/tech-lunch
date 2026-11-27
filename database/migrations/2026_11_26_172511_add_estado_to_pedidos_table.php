<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::table('pedidos', function (Blueprint $table) {
        $table->string('estado', 15)->default('Pendiente')->after('total');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::table('pedidos', function (Blueprint $table) {
        $table->dropColumn('estado');
    });
    }
};
