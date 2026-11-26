<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['codigo', 'descripcion', 'porcentaje', 'fecha_inicio', 'fecha_fin', 'estado'])]
class Cupon extends Model
{
    // Laravel buscaría "cupons" (plural en inglés): le decimos el nombre real
    protected $table = 'cupones';

    // Los 3 estados posibles de un cupón
    public const DISPONIBLE = 'Disponible';
    public const USADO = 'Usado';
    public const INACTIVO = 'Inactivo';

    // Un cupón nuevo empieza disponible
    protected $attributes = ['estado' => self::DISPONIBLE];

    protected function casts(): array
    {
        return [
            'porcentaje' => 'integer',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
        ];
    }
    #[Scope]
    protected function vigentes(Builder $consulta): void
    {
        $consulta->where('estado', self::DISPONIBLE)
            ->whereDate('fecha_inicio', '<=', today())
            ->whereDate('fecha_fin', '>=', today());
    }
    // Texto del estado para mostrar en el listado del admin
    public function situacion(): string
    {
        if ($this->estado !== self::DISPONIBLE) {
            return $this->estado;          // "Usado" o "Inactivo"
        }
        if ($this->fecha_inicio->isFuture()) {
            return 'Programado';
        }
        if ($this->fecha_fin->lt(today())) {
            return 'Vencido';
        }
        return 'Vigente';
    }
    // El pedido donde se canjeó este cupón (o null si no se usó)
    public function pedido(): HasOne
    {
        return $this->hasOne(Pedido::class);
    }
}