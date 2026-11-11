<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuarios fijos para los escenarios de prueba (contraseña: password)
        User::create([
            'name' => 'Administrador TECH-LUNCH',
            'email' => 'admin@techlunch.test',
            'password' => Hash::make('password'),
        ])->assignRole('administrador');

        User::create([
            'name' => 'Personal del cafetin',
            'email' => 'personal@techlunch.test',
            'password' => Hash::make('password'),
        ])->assignRole('personal');

        User::create([
            'name' => 'Cliente de prueba',
            'email' => 'cliente@techlunch.test',
            'password' => Hash::make('password'),
        ])->assignRole('cliente');

        // Cinco clientes más con nombres en español (APP_FAKER_LOCALE=es_PE)
        for ($i = 1; $i < 5; $i++) {
            User::create([
                'name' => fake()->firstName() . ' ' . fake()->lastName(),
                'email' => "cliente{$i}@techlunch.test",
                'password' => Hash::make('password'),
            ])->assignRole('cliente');
        }
    }
}
