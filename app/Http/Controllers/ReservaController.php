<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearClienteRequest;
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
        //buscamos a la persona segun su email o telefono
        $persona = Persona::whereRelation('contactos', 'descripcion', $request->email)
            ->with('contactos', 'sexo', 'documentos')
            ->first();

        //Verificamos si se obtuvo una persona
        if (!$persona) {
            //Si es que no se encontro una persona con ese email o telefono
            DB::transaction(function() use($request, $cancha) {
                //Creamos a la persona(reservante)
                $reservante     = $this->crearReservante($request);
                //creamos la reserva con la persona recien creada
                $reserva        = $this->crearReserva($request, $reservante, $cancha);
            });
        } else {
            //creamos la reserva con la persona encontrada segun el email o telefono
            $reservante = $persona;
            $reserva    = $this->crearReserva($request, $reservante, $cancha);
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

    public function crearClienteNuevo(CrearClienteRequest $request)
    {
        return "hola mundo";
    }

    /**
     * Crear una nueva persona internamente para poder reservar
     * @param Request $request los datos enviados en el formulario
     * @return Persona Devuelve la persona creada
     */
    private function crearReservante(Request $request) :Persona 
    {
        $persona = Persona::create([
            'nombre' => $request->input('nombre'),
            //'email' => $request->input('email'),
            // otros campos si tenés...
        ]);

        $persona->contactos()->create([
            'descripcion' => $request->input('contacto'),
            // 'rela_tipo_contacto' => 1, // email
            'rela_tipo_contacto' => $request->input('tipo-contacto'), // Email o telefono
        ]);

        // $persona->documentos()->create([
        //     'descripcion' => null,
        //     'tipo_documento_id' => 1, // o el default
        // ]);

        return $persona;
    }

    /**
     * Creamos la reserva, soporta reserva interna y externa
    */
    private function crearReserva(Request $request, $reservante, $cancha) : ?Reserva
    {
        //falta hacer la logica
        return null; // o devolver la reserva creada
    }
}
