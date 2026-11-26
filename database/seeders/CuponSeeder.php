<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CuponSeeder extends Seeder
{
    public function run(): void
    {
        $cupones = [
            ['codigo' => 'BIENVENIDA10', 'descripcion' => 'Descuento por tu primer pedido',      'porcentaje' => 10, 'desde' => -1,  'hasta' => 30, 'estado' => 'Disponible'], // vigente
            ['codigo' => 'TECSUP20',     'descripcion' => 'Semana de exámenes',                   'porcentaje' => 20, 'desde' => -2,  'hasta' => 5,  'estado' => 'Disponible'], // vigente
            ['codigo' => 'NAVIDAD30',    'descripcion' => 'Campaña de Navidad',                   'porcentaje' => 30, 'desde' => 10,  'hasta' => 20, 'estado' => 'Disponible'], // programado
            ['codigo' => 'VERANO15',     'descripcion' => 'Promoción de inicio de ciclo',         'porcentaje' => 15, 'desde' => -30, 'hasta' => -5, 'estado' => 'Disponible'], // vencido
            ['codigo' => 'FERIA25',      'descripcion' => 'Feria de proyectos (ya fue canjeado)', 'porcentaje' => 25, 'desde' => -5,  'hasta' => 5,  'estado' => 'Usado'],      // usado
        ];
        foreach ($cupones as $cupon) {
            DB::table('cupones')->insert([
                'codigo' => $cupon['codigo'],
                'descripcion' => $cupon['descripcion'],
                'porcentaje' => $cupon['porcentaje'],
                'fecha_inicio' => today()->addDays($cupon['desde']),
                'fecha_fin' => today()->addDays($cupon['hasta']),
                'estado' => $cupon['estado'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}