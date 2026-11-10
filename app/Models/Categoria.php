<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nombre', 'descripcion', 'icono', 'estado'])]
class Categoria extends Model
{
    // Tipo de dato de las columnas al leerlas
    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
        ];
    }

    // Una categoría tiene muchos productos (productos.categoria_id)
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class);
    }

    // Categoria::activas() -> solo las categorías con estado = 1
    #[Scope]
    protected function activas(Builder $consulta): void
    {
        $consulta->where('estado', true);
    }
}