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
        Schema::table('productos', function (Blueprint $table) {
        $table->text('descripcion')->nullable()->after('nombre');
        $table->string('imagen')->nullable()->after('stock');
        $table->boolean('destacado')->default(false)->after('imagen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn(['descripcion', 'imagen', 'destacado']);
            
        });
    }
};
