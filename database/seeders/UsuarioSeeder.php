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
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@techlunch.test',
            'password' => Hash::make('password'),
        ])->assignRole('administrador');

        User::create([
            'name' => 'Personal del cafetín',
            'email' => 'personal@techlunch.test',
            'password' => Hash::make('password'),
        ])->assignRole('personal');

        User::create([
            'name' => 'Cliente de prueba',
            'email' => 'cliente@techlunch.test',
            'password' => Hash::make('password'),
        ])->assignRole('cliente');
    }
}
