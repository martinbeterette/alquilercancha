<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            "role.menu",
            "role.view",
            "role.create",
            "role.edit",
            "role.delete",
            "role.exportar",
            "usuario.menu",
            "usuario.view",
            "usuario.create",
            "usuario.edit",
            "usuario.delete",
            "usuario.exportar"
        ];

        foreach($permissions as $key => $value) {
            Permission::create(['name' => $value]);
        }
    }
}
