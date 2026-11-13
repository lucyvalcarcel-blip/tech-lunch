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
        Schema::table('categorias', function (Blueprint $table) {
             $table->string('descripcion')->nullable()->after('nombre');
             $table->string('icono', 50)->nullable()->after('descripcion');
              $table->boolean('estado')->default(true)->after('icono');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categorias', function (Blueprint $table) {
              $table->dropColumn(['descripcion', 'icono', 'estado']);    

        });
    }
};
