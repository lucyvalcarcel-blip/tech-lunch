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
        return $this->belongsTo(Zona::class);
    }
}