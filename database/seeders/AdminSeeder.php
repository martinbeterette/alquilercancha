<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Contacto;
use App\Models\Rol;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

       /*  //VERIFICAR SI EXISTE EMAIL
        $persona = Persona::create([
            'nombre' => null,
            'apellido' => null,
            'fecha_nacimiento' => null,
            'rela_sexo' => null,
            'activo' => false,
        ]);

        $contacto = Contacto::create([
            'descripcion' => 'admin@admin.com',
            'rela_tipo_contacto' => 1,
            'rela_persona' => $persona->id,
            'activo' => false,
        ]);

        Usuario::create([
            'username' => 'admin0001',
            'rela_rol' => 1,
            'rela_contacto' => $contacto->id,
            'password' => Hash::make('admin0001'),
            'activo' => true,
        ]); */

        $roleAdmin = Role::where('name', 'admin')->first();
        $roleLoquito = Role::where('name', 'loquito')->first();

        //creamos la persona
        $persona = Persona::create([
            'nombre' => 'admin',
            'apellido' => 'admin',
            'fecha_nacimiento' => '0001-01-01',
            'rela_sexo' => 1,
        ]);

        //creamos el documento
        $persona->documentos()->create([
            'rela_tipo_documento' => 1,
            'descripcion' => '00000000',
        ]);
        //creamos el admin
        $admin = User::create([
            'name' => 'admin123',
            'email' => 'admin123@admin.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'rela_persona' => $persona->id,
        ]);

        $admin->assignRole($roleAdmin);

        //bonus: creamos el contacto del admin
        $persona->contactos()->create([
            'descripcion' => $admin->email,
            'rela_tipo_contacto' => 1,
        ]);
       
    }
}
