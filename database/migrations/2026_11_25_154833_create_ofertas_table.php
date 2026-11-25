<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Nota   crear tablas de ofertass */
    public function up(): void
    {
    Schema::create('ofertas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('producto_id')->constrained('productos')->restrictOnDelete();
        $table->string('tipo', 20);
        $table->decimal('precio_oferta', 8, 2);
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->boolean('estado')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
