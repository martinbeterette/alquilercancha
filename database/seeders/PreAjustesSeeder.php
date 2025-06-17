<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PreAjustesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $now = Carbon::now();

        // Tipo Zona
        DB::table('tipo_zona')->insert([
            'descripcion' => 'Cancha',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Estado Zona
        DB::table('estado_zona')->insert([
            [
                'descripcion' => 'Buen Estado',
                'created_at' => $now,
                'updated_at' => $now
            ], [
                'descripcion' => 'Mal Estado',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
        

        // Superficies
        DB::table('superficie')->insert([
            [
                'id' => 1, // para asegurar que tenga ID fijo si lo necesitás
                'descripcion' => 'cesped',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'id' => 2,
                'descripcion' => 'piso',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Deporte
        DB::table('deporte')->insert([
            'id' => 1,
            'descripcion' => 'Fútbol',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        // Tipo Deporte
        DB::table('tipo_deporte')->insert([
            [
                'descripcion' => 'Fútbol 5',
                'rela_deporte' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'descripcion' => 'Fútbol 7',
                'rela_deporte' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
    }
}
