<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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