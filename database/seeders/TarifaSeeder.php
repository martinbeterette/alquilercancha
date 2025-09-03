<?php

namespace Database\Seeders;

use App\Models\Sucursal;
use App\Models\Tarifa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TarifaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //obtenemos las sucursales
        $sucursal1 = Sucursal::find(1);
        $sucursal2 = Sucursal::find(2);
        
        //creamos las tarifas de la sucursal 1
        $sucursal1->tarifas()->create([
            'nombre' => 'Dia',
            'hora_desde' => '02:00:00',
            'hora_hasta' => '20:00:00',
            'precio' => 10000.00,
        ]);
        $sucursal1->tarifas()->create([
            'nombre' => 'Noche',
            'hora_desde' => '20:00:00',
            'hora_hasta' => '02:00:00',
            'precio' => 15000.00,
        ]);

        //creamos la tarifa de la ssucursal 2
        $sucursal2->tarifas()->create([
            'nombre' => 'Dia',
            'hora_desde' => '04:00:00',
            'hora_hasta' => '19:00:00',
            'precio' => 9000.00,
        ]);
        $sucursal2->tarifas()->create([
            'nombre' => 'Noche',
            'hora_desde' => '19:00:00',
            'hora_hasta' => '04:00:00',
            'precio' => 12000.00,
        ]);
    }
}
