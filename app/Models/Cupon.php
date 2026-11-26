<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
}