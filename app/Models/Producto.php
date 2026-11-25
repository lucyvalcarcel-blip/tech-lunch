<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['nombre', 'descripcion', 'precio', 'stock', 'imagen', 'destacado', 'estado', 'categoria_id'])]
class Producto extends Model
{
    // Tipo de dato de las columnas al leerlas
    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'stock' => 'integer',
            'destacado' => 'boolean',
            'estado' => 'boolean',
        ];
    }

    // Un producto pertenece a una categoría (productos.categoria_id)
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);

    }
    
    // Un producto puede tener muchas ofertas (vigentes, vencidas o programadas)
    public function ofertas(): HasMany
    {
        return $this->hasMany(Oferta::class);
    }

    // Solo la oferta de HOY (activa y dentro de sus fechas), o null si no tiene
    public function ofertaVigente(): HasOne
    {
        return $this->hasOne(Oferta::class)->vigentes()->latest('fecha_inicio');
    }

    // Precio que se cobra HOY: el de oferta si tiene una vigente, si no el normal
    public function precioFinal(): float
    {
        return (float) ($this->ofertaVigente?->precio_oferta ?? $this->precio);
    }

    // Producto::activos() -> solo los productos con estado = 1
    #[Scope]
    protected function activos(Builder $consulta): void
    {
        $consulta->where('estado', true);
    }

    // Producto::destacados() -> solo los productos destacados
    #[Scope]
    protected function destacados(Builder $consulta): void
    {
        $consulta->where('destacado', true);
    }
}