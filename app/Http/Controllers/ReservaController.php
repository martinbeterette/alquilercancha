<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearClienteRequest;
use App\Models\Contacto;
use App\Models\Persona;
use App\Models\Reserva;
use App\Models\Sucursal;
use App\Models\Zona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
    public function store(Request $request, Persona $persona, Zona $cancha)
    {
        // Validaciones básicas
        $request->validate([
            'fecha'       => 'required|date',
            'hora_desde'  => 'required|date_format:H:i',
            'hora_hasta'  => 'required|date_format:H:i|after:hora_desde',
        ]);

        $horaDesde = Carbon::parse($request->input('hora_desde'))->format('H:i:s');
        $horaHasta = Carbon::parse($request->input('hora_hasta'))->format('H:i:s');

        if (!$this->horarioEstaDisponible(
            $request->input('fecha'),
            $horaDesde, 
            $horaHasta, 
            $cancha
            )
        ) {
                // return "esta ocupado";
                return back()->withErrors(['El horario seleccionado no está disponible. Por favor, elija otro.']);
        } 
        $reserva = $this->crearReserva($request, $persona, $cancha);
        
        return "Reserva Creada exitosamente, Reserva ID: {$reserva->id}";
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
        // nombre:martin
        // contacto: martin@example
        // tipo_contacto: 1

        $persona = Persona::create(["nombre" => $request->nombre]);
        $contacto = $persona->contactos()->create(["descripcion" => $request->contacto, "rela_tipo_contacto" => $request->tipo_contacto]);

        // $contacto->delete();
        // $persona->delete();
        return redirect()->route('seleccionar.hora.y.cancha', ["persona" => $persona]);
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
            'rela_tipo_contacto' => $request->input('tipo_contacto'), // Email o telefono
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
    private function crearReserva(Request $request, Persona $persona, Zona $cancha) : ?Reserva
    {
        return Reserva::create([
            'observacion'        => $request->input('observacion', null),
            'fecha'              => $request->input('fecha'),
            'hora_desde'         => $request->input('hora_desde')->format('H:i:s'),
            'hora_hasta'         => $request->input('hora_hasta')->format('H:i:s'),
            'precio'             => null, // lo vas a calcular con tarifas más adelante
            'estado'             => 'Pendiente',
            'metodo_pago'        => 'Pendiente',
            'tipo_reserva'       => 'Interna',
            'cancelacion_motivo' => null,
            'creado_por'         => null, // metodo auth para insertar el id
            'rela_persona'       => $persona->id,
            'rela_zona'          => $cancha->id,
        ]);
    }

    public function seleccionarHoraYCancha(Persona $persona)
    {
        $sucursales = Sucursal::pluck('nombre', 'id');
        return view('reserva.seleccionar_cancha', [
            "sucursales" => $sucursales,
            "persona" => $persona,          
        ]);
    }

    /**
     * Pagina para seleccionar la hora a reservar
     * @todo Refactorizar codigo y elegir nombres apropiados
     */  
    public function seleccionarHorario(Persona $persona, Zona $cancha)
    {
        // Lógica para seleccionar horario
        // Aquí deberías implementar la lógica para mostrar los horarios disponibles
        // según la cancha seleccionada y la persona.
        return view('reserva.seleccionar_horario', [
            'persona' => $persona,
            'cancha' => $cancha->load('superficie', 'tipoDeporte'),
        ]);
    }

    /**
     * Verifica si un horario está disponible para una cancha en una fecha.
     *
     * @param string $fecha       Formato 'YYYY-MM-DD'
     * @param string $horaDesde   Formato 'HH:MM'
     * @param string $horaHasta   Formato 'HH:MM'
     * @param Cancha $cancha
     * @return bool
     */
    private function horarioEstaDisponible(string $fecha, string $horaDesde, string $horaHasta, Zona $cancha): bool
    {
        $desde = Carbon::parse("{$fecha} {$horaDesde}")->format('H:i:s');
        $hasta = Carbon::parse("{$fecha} {$horaHasta}")->format('H:i:s');

        $existeCruce = Reserva::where('rela_zona', $cancha->id)
            ->whereDate('fecha', $fecha)
            ->where(function($query) use ($desde, $hasta) {
                $query->where('hora_desde', '<', $hasta)
                      ->where('hora_hasta', '>', $desde);
            })
            ->exists();

        return !$existeCruce;
    }

    public function verReservas()
    {
        // Traemos todas las reservas con persona y cancha cargadas
        $reservas = Reserva::with(['persona', 'zona'])->get();

        return view('reserva.ver_reservas', compact('reservas'));
    }
}
