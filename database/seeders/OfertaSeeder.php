<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OfertaSeeder extends Seeder
{
    public function run(): void
    {
        // Fechas RELATIVAS a hoy: siempre habrá ofertas vigentes
        // desde/hasta = días desde hoy (negativo = días atrás)
        $ofertas = [
            ['producto' => 'Lomo saltado',     'tipo' => 'Descuento',      'descuento' => 0.20, 'desde' => -2,  'hasta' => 5],   // vigente
            ['producto' => 'Chicha morada',    'tipo' => 'Oferta del día', 'descuento' => 0.15, 'desde' => 0,   'hasta' => 0],   // vigente solo hoy
            ['producto' => 'Keke de vainilla', 'tipo' => 'Combo',          'descuento' => 0.10, 'desde' => 3,   'hasta' => 10],  // programada
            ['producto' => 'Alfajor',          'tipo' => 'Descuento',      'descuento' => 0.25, 'desde' => -10, 'hasta' => -3],  // vencida
        ];

        foreach ($ofertas as $oferta) {
            $producto = DB::table('productos')->where('nombre', $oferta['producto'])->first();

            DB::table('ofertas')->insert([
                'producto_id' => $producto->id,
                'tipo' => $oferta['tipo'],
                'precio_oferta' => round($producto->precio * (1 - $oferta['descuento']), 2),
                'fecha_inicio' => today()->addDays($oferta['desde']),
                'fecha_fin' => today()->addDays($oferta['hasta']),
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}