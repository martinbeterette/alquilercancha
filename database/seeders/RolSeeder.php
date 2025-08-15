<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;
use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Rol::create([
            'descripcion' => 'Administrador',
            'activo' => true,
        ]);
        
        Rol::create([
            'descripcion' => 'Usuario',
            'activo' => true,
        ]);

        Rol::create([
            'descripcion' => 'Empleado',
            'activo' => true,
        ]);

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        
        Role::create([
            'name' => 'loquito',
            'guard_name' => 'web',
        ]);
    }
}
