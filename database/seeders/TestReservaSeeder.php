<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Reserva;
use Carbon\Carbon;

class TestReservaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reserva 1 → día de hoy
        Reserva::create([
            'observacion'        => 'Reserva de prueba 1',
            'fecha'              => '2025-08-31', //Carbon::today()->toDateString() Ej: 2025-08-21
            'hora_desde'         => '2025-08-31 10:00:00',
            'hora_hasta'         => '2025-08-31 11:30:00',
            'precio'             => 1500.00,
            'estado'             => 'Confirmada',
            'metodo_pago'        => 'Efectivo',
            'tipo_reserva'       => 'Interna',
            'cancelacion_motivo' => null,
            'creado_por'         => 1, // id de usuario cualquiera
            'rela_persona'       => 1, // asegurate que exista en persona
            'rela_zona'          => 1, // asegurate que exista en zona
        ]);

        // Reserva 2 → día de mañana
        Reserva::create([
            'observacion'        => 'Reserva de prueba 2',
            'fecha'              => '2025-09-01', // Ej: 2025-08-22
            'hora_desde'         => '2025-09-01 18:00:00',
            'hora_hasta'         => '2025-09-01 20:00:00',
            'precio'             => 2000.00,
            'estado'             => 'Pendiente',
            'metodo_pago'        => 'Tarjeta',
            'tipo_reserva'       => 'Interna',
            'cancelacion_motivo' => null,
            'creado_por'         => 1,
            'rela_persona'       => 1,
            'rela_zona'          => 1,
        ]);

        // Reserva 3 → día de mañana
        Reserva::create([
            'observacion'        => 'Reserva de prueba 2',
            'fecha'              => '2025-09-01', // Ej: 2025-08-22
            'hora_desde'         => '2025-09-01 23:00:00',
            'hora_hasta'         => '2025-09-02 00:30:00',
            'precio'             => 2000.00,
            'estado'             => 'Pendiente',
            'metodo_pago'        => 'Tarjeta',
            'tipo_reserva'       => 'Interna',
            'cancelacion_motivo' => null,
            'creado_por'         => 1,
            'rela_persona'       => 1,
            'rela_zona'          => 1,
        ]);
    }
}
