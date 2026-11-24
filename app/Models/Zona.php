<?php
// ya habia creado las migraciones, y los seder y el modelos. ahora estoy rellenado el modelo porque ya llene la tabla.  
namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[Fillable(['nombre', 'descripcion', 'estado'])]
class Zona extends Model
{
     protected function casts(): array
    {
        return [
            'estado' => 'boolean',
        ];
    }

    // Una zona tiene muchos pedidos (pedidos.zona_id)
    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class);
    }

    // Zona::activas() -> solo las zonas que se atienden
    #[Scope]
    protected function activas(Builder $consulta): void
    {
        $consulta->where('estado', true);
    }
}
