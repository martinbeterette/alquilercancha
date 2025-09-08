<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membresia;
use App\Models\Complejo;

class MembresiaSeeder extends Seeder
{
    public function run(): void
    {
        $complejo1 = Complejo::first();

        // Complejo 1
        Membresia::create([
            'complejo_id' => $complejo1->id,
            'nombre' => 'Mensual',
            'descripcion' => 'Acceso ilimitado por 30 días',
            'precio' => 10000,
            'descuento_base' => 0,
        ]);

        Membresia::create([
            'complejo_id' => $complejo1->id,
            'nombre' => 'Premium',
            'descripcion' => 'Acceso ilimitado + clases especiales',
            'precio' => 18000,
            'descuento_base' => 5,
        ]);

        Membresia::create([
            'complejo_id' => $complejo1->id,
            'nombre' => 'Familiar',
            'descripcion' => 'Hasta 4 personas con acceso ilimitado',
            'precio' => 25000,
            'descuento_base' => 10,
        ]);
    }
}
