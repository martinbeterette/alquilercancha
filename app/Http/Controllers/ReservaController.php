<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, int $cancha)
    {
        $persona = Persona::whereRelation('contactos', 'descripcion', $request->email)
            ->with('contactos', 'sexo', 'documentos')
            ->first();

        if (!$persona) {
            DB::transaction(function() use($request, $cancha) {
                $reservante = $this->crearReservante($request);
                $reserva = $this->crearReserva($request, $reservante, $cancha);
            });
        } else {
            $reservante = $persona;
            $reserva = $this->crearReserva($request, $reservante, $cancha);
            return "lo mismo pero en la orta salida";
        }
        return "retornamos alguna vista o redireccion";
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }

    /**
     * Crear una nueva persona internamente para poder reservar
     */
    private function crearReservante(Request $request) :Persona 
    {
        $persona = Persona::create([
            'nombre' => $request->input('nombre'),
            'email' => $request->input('email'),
            // otros campos si tenés...
        ]);

        $persona->contactos()->create([
            'descripcion' => $request->input('email'),
            'tipo_contacto_id' => 1, // ejemplo
        ]);

        $persona->documentos()->create([
            'numero' => null,
            'tipo_documento_id' => 1, // o el default
        ]);

        return $persona;
    }

    private function crearReserva(Request $request, $reservante, $cancha)
    {
        //falta hacer la logica
    }
}
