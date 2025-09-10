<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promocion;
use App\Models\Membresia;
use App\Models\Complejo;
use Carbon\Carbon;

class PromocionSeeder extends Seeder
{
    public function run(): void
    {
        $complejo1 = Complejo::first();
        $membresiaMensual = Membresia::where('nombre', 'Mensual')->first();

        // Promo sobre una membresía específica
        Promocion::create([
            'complejo_id' => $complejo1->id,
            'membresia_id' => $membresiaMensual->id,
            'nombre' => 'Promo Navidad',
            'descripcion' => '20% de descuento por las fiestas',
            'tipo_descuento' => 'porcentaje',
            'valor_descuento' => 20,
            'fecha_inicio' => Carbon::now()->subDays(5),
            'fecha_fin' => Carbon::now()->addDays(10),
            'activo' => true,
        ]);

        // Promo general para todo el complejo
        Promocion::create([
            'complejo_id' => $complejo1->id,
            'membresia_id' => null,
            'nombre' => 'Semana del Amigo',
            'descripcion' => 'Descuento de $2000 en todas las membresías',
            'tipo_descuento' => 'monto_fijo',
            'valor_descuento' => 2000,
            'fecha_inicio' => Carbon::now()->addDays(15),
            'fecha_fin' => Carbon::now()->addDays(22),
            'activo' => true,
        ]);
    }
}
