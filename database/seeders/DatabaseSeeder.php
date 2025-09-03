<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RolSeeder::class,
            TipoContactoSeeder::class,
            SexoSeeder::class,
            TipoDocumentoSeeder::class,
            AdminSeeder::class,
            PersonaSeeder::class,
            PreAjustesSeeder::class,
            ComplejoSeeder::class,
            TestReservaSeeder::class,
            ModuloSeeder::class,
            TarifaSeeder::class,
        ]);
        
    }
}
