<?php
//* Ofertas 
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['producto_id', 'tipo', 'precio_oferta', 'fecha_inicio', 'fecha_fin', 'estado'])]
class Oferta extends Model
{
    // Los tipos de oferta que se pueden elegir en el formulario
    public const TIPOS = ['Descuento', 'Oferta del día', 'Combo'];

    // Una oferta nueva empieza activa
    protected $attributes = ['estado' => true];

    protected function casts(): array
    {
        return [
            'precio_oferta' => 'decimal:2',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'estado' => 'boolean',
        ];
    }

    // Cada oferta pertenece a un producto (ofertas.producto_id)
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    // Oferta::vigentes() -> activas y con hoy dentro de sus fechas
    #[Scope]
    protected function vigentes(Builder $consulta): void
    {
        $consulta->where('estado', true)
            ->whereDate('fecha_inicio', '<=', today())
            ->whereDate('fecha_fin', '>=', today());
    }

    // Texto del estado para mostrar en el listado del admin
    public function situacion(): string
    {
        if (! $this->estado) {
            return 'Inactiva';
        }
        if ($this->fecha_inicio->isFuture()) {
            return 'Programada';
        }
        if ($this->fecha_fin->lt(today())) {
            return 'Vencida';
        }
        return 'Vigente';
    }
}