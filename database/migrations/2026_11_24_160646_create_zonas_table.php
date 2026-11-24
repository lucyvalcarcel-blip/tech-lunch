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

    // --- lucy - 2  cree la tabla de zonas para poder tener un listado de zonas y poder asignarlas a los pedidos, ya que en la tabla de pedidos no se puede poner un campo de texto para la zona, ya que se tiene que seleccionar de un listado de zonas predefinidas. --- lucy
        Schema::create('zonas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50)->unique();
            $table->string('descripcion', 100)->nullable();
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zonas');
    }
};
