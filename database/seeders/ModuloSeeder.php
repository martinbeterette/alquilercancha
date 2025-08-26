<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;
use Spatie\Permission\Models\Role;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        // Creamos algunos módulos que también son menús
        $modulos = [
            [
                'name' => 'Inicio',
                'slug' => '/home',
                'icon' => 'fas fa-home',
                'orden' => 1,
            ],
            [
                'name' => 'Sucursales',
                'slug' => '/sucursal',
                'icon' => 'fas fa-store',
                'orden' => 2,
            ],
            [
                'name' => 'Tablas maestras',
                'slug' => '/tablas-maestras',
                'icon' => 'fas fa-database',
                'orden' => 3,
            ],
            [
                'name' => 'Administración',
                'slug' => '/admin',
                'icon' => 'fas fa-cogs',
                'orden' => 4,
            ],/* 
            [
                'name' => 'Membresías',
                'slug' => '/membresias',
                'icon' => 'fas fa-id-card',
                'orden' => 5,
            ],
            [
                'name' => 'Tarifas',
                'slug' => '/tarifas',
                'icon' => 'fas fa-tags',
                'orden' => 6,
            ], */
        ];

        foreach ($modulos as $data) {
            $modulo = Modulo::create($data);

            // Asignamos algunos módulos a roles por defecto
            // Ajustá los nombres de roles según tu DB
            $adminRole = Role::where('name', 'admin')->first();
            $loquitoRole = Role::where('name', 'loquito')->first();

            // Ejemplo: admin ve todo
            $modulo->roles()->attach($adminRole);

            // Ejemplo: loquito solo ve Ventas y Reservas
            if (in_array($modulo->name, ['Ventas', 'Reservas'])) {
                $modulo->roles()->attach($loquitoRole);
            }
        }
    }
}
