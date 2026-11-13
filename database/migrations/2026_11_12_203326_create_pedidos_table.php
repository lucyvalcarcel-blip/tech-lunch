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
        
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 10)->nullable()->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->string('celular', 15);
            $table->string('metodo_pago', 10);
            $table->string('numero_operacion', 20);
            $table->decimal('total', 8, 2);
            $table->timestamps();
            });    
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
