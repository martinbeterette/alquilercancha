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
                'name' => 'Ventas',
                'slug' => '#',
                'icon' => 'fas fa-shopping-cart',
                'orden' => 1,
            ],
            [
                'name' => 'Compras',
                'slug' => '#',
                'icon' => 'fas fa-credit-card',
                'orden' => 2,
            ],
            [
                'name' => 'Reservas',
                'slug' => '#',
                'icon' => 'fas fa-calendar-check',
                'orden' => 3,
            ],
            [
                'name' => 'Usuarios',
                'slug' => '#',
                'icon' => 'fas fa-users',
                'orden' => 4,
            ],
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
