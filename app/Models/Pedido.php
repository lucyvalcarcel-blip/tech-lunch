<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['codigo', 'user_id', 'celular', 'tipo_entrega', 'zona_id', 'aula', 'referencia',
    'hora_entrega', 'limite_entrega', 'costo_delivery', 'metodo_pago', 'numero_operacion',
    'tarjeta_marca', 'tarjeta_ultimos4', 'cuotas', 'total'])]


class Pedido extends Model
{


    // Reglas del delivery (un solo lugar para cambiarlas)
    public const COSTO_DELIVERY = 2.00;
    public const MINUTOS_LIMITE = 10;
    public const HORA_CIERRE = '17:00';
    public const HORAS = [
        '12:00' => '12:00 p. m.',
        '12:30' => '12:30 p. m.',
        '13:00' => '1:00 p. m.',
        '13:30' => '1:30 p. m.',
        '14:00' => '2:00 p. m.',
        '14:30' => '2:30 p. m.',
    ];

    protected function casts(): array
    {
        return ['total' => 'decimal:2',
                 'costo_delivery' => 'decimal:2',
                 'hora_entrega' => 'datetime',
                 'limite_entrega' => 'datetime',
                 'cuotas' => 'integer',];
    }
    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }



    
       public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }
}
