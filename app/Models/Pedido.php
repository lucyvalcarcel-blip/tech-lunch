<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['codigo', 'user_id', 'celular', 'tipo_entrega', 'zona_id', 'aula', 'referencia',
    'hora_entrega', 'limite_entrega', 'costo_delivery', 'cupon_id', 'descuento', 'metodo_pago', 'numero_operacion',
    'tarjeta_marca', 'tarjeta_ultimos4', 'cuotas', 'total', 'estado'])]   // (Gabriel) + cupon_id, descuento


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

    // (Fabrizio) Estados del pedido
    public const PENDIENTE = 'Pendiente';
    public const CONFIRMADO = 'Confirmado';
    public const ENTREGADO = 'Entregado';
    public const RECHAZADO = 'Rechazado';
    public const NO_LLEGO = 'No llegó';
    public const ESTADOS = [self::PENDIENTE, self::CONFIRMADO, self::ENTREGADO, self::RECHAZADO, self::NO_LLEGO];

    // Un pedido nuevo empieza Pendiente (el encargado valida el pago)
    protected $attributes = ['estado' => self::PENDIENTE];


    protected function casts(): array
    {
        return ['total' => 'decimal:2',
                 'costo_delivery' => 'decimal:2',
                 'descuento' => 'decimal:2',          // (Gabriel)
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

    // (Gabriel) El cupón que se usó en este pedido (o null)
    public function cupon(): BelongsTo
    {
        return $this->belongsTo(Cupon::class);
    }

    // (Fabrizio) Qué botón puede usar el encargado según el estado
    public function puedeValidar(): bool
    {
        return $this->estado === self::PENDIENTE;
    }

    public function puedeRechazar(): bool
    {
        return $this->estado === self::PENDIENTE;
    }

    public function puedeEntregar(): bool
    {
        return $this->estado === self::CONFIRMADO;
    }

    // "No llegó" solo después del tiempo límite
    public function puedeMarcarNoLlego(): bool
    {
        return $this->estado === self::CONFIRMADO && now()->greaterThan($this->limite_entrega);
    }
}