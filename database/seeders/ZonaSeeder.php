<?php
// - lucy query builder para la tabla de zonas, para poder hacer un listado de zonas y poder asignarlas a los pedidos, ya que en la tabla de pedidos no se puede poner un campo de texto para la zona, ya que se tiene que seleccionar de un listado de zonas predefinidas.
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $zonas = [
            ['nombre' => 'Pabellón A', 'descripcion' => 'Aulas 101 a 115'],
            ['nombre' => 'Pabellón B', 'descripcion' => 'Aulas 201 a 215'],
            ['nombre' => 'Pabellón C', 'descripcion' => 'Laboratorios de cómputo'],
            ['nombre' => 'Biblioteca', 'descripcion' => 'Sala de lectura'],
        ];

        foreach ($zonas as $zona) {
            DB::table('zonas')->insert([
                'nombre' => $zona['nombre'],
                'descripcion' => $zona['descripcion'],
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
