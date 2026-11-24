<?php
// paso 3 - ya habia creado la migracion para esta tabla, ahora estoy agregando los campos de entrega y pago a la tabla de pedidos.

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
            // Entrega 
        $table->string('tipo_entrega', 10)->default('recojo')->after('celular');
        $table->foreignId('zona_id')->nullable()->after('tipo_entrega')
            ->constrained('zonas')->restrictOnDelete();
        $table->string('aula', 50)->nullable()->after('zona_id');
        $table->string('referencia', 100)->nullable()->after('aula');
        $table->dateTime('hora_entrega')->nullable()->after('referencia');
        $table->dateTime('limite_entrega')->nullable()->after('hora_entrega');
        $table->decimal('costo_delivery', 8, 2)->default(0)->after('limite_entrega');

        // Pago con tarjeta (nunca el número completo ni el CVV)
        $table->string('tarjeta_marca', 20)->nullable()->after('numero_operacion');
        $table->string('tarjeta_ultimos4', 4)->nullable()->after('tarjeta_marca');
        $table->unsignedTinyInteger('cuotas')->nullable()->after('tarjeta_ultimos4');

        // Con tarjeta no hay número de operación
        $table->string('numero_operacion', 20)->nullable()->change();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function (Blueprint $table) {
            //

              $table->dropConstrainedForeignId('zona_id');
               $table->dropColumn([
              'tipo_entrega', 'aula', 'referencia', 'hora_entrega', 'limite_entrega',
               'costo_delivery', 'tarjeta_marca', 'tarjeta_ultimos4', 'cuotas',
        ]);
        $table->string('numero_operacion', 20)->nullable(false)->change();

            
        });
    }
};
