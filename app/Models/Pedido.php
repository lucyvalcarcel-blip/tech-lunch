<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
#[Fillable(['codigo', 'user_id', 'celular', 'metodo_pago', 'numero_operacion', 'total'])]
class Pedido extends Model
{
    protected function casts(): array
    {
        return ['total' => 'decimal:2'];
    }
    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class);
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}