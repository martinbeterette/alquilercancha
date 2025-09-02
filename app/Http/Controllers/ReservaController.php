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
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;

class ReservaController extends Controller
{
    private $rules = [
        'fecha'       => 'required|date|after_or_equal:today',
        'hora_desde'  => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        'hora_hasta'  => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
    ];

    private $messages = [
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha debe ser una fecha válida.',
        'fecha.after_or_equal' => 'La fecha no puede ser una pasada.',
        'hora_desde.required' => 'La hora de inicio es obligatoria.',
        'hora_hasta.required' => 'La hora de fin es obligatoria.',
        'hora_desde.regex' => 'El formato de hora de inicio debe ser valido HH:MM o HH:MM:SS.',
        'hora_hasta.regex' => 'El formato de hora de finalizacion debe ser valido HH:MM o HH:MM:SS.',
    ];
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
        // return new JsonResponse($request->all());

        // Validaciones básicas
        $request->validate($this->rules, $this->messages);
       
        $fecha      = $request->input('fecha');
        $horaDesde  = $request->input('hora_desde');
        $horaHasta  = $request->input('hora_hasta');
        $precio     = $request->input('precio', null); //opcional
        $senia      = $request->input('senia', null);  //opcional

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
        
        //si paso toda la validacion creamos los objetos datetime
        $desde = Carbon::parse("{$fecha} {$horaDesde}");
        $hasta = Carbon::parse("{$fecha} {$horaHasta}");

        // Si horaHasta es menor que horaDesde, asumimos que es del día siguiente
        if ($hasta->lessThanOrEqualTo($desde)) {
            $hasta->addDay();
        }
        $reserva = $this->crearReserva($fecha, $desde, $hasta, $persona, $cancha, $precio, $senia);
        
        return redirect()->route('ver.reservas')->with('success', 'Reserva creada exitosamente.');
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
     * @param CrearClienteRequest $request los datos enviados en el formulario ya validados
     * @return Persona Devuelve la persona creada
     */
    public function crearClienteNuevo(CrearClienteRequest $request)
    {
        $persona = Persona::create(["nombre" => $request->nombre]);
        $contacto = $persona->contactos()->create(["descripcion" => $request->contacto, "rela_tipo_contacto" => $request->tipo_contacto]);
        return redirect()->route('seleccionar.hora.y.cancha', ["persona" => $persona]);
    }

    /**
     * Metodo aislado para crear la reserva, listo para ser llamado
     * @param string $fecha             Formato 'YYYY-MM-DD'
     * @param string $fechaHoraDesde    Formato 'HH:MM:SS'
     * @param string $fechaHoraHasta    Formato 'HH:MM:SS'
     * @param float|null $precio        Precio de la reserva (opcional)
     * @param float|null $senia         Señia de la reserva (opcional)
     * @param Persona $persona          La persona que hace la reserva
     * @param Zona $cancha              La cancha a reservar
     * @return Reserva|null Devuelve la reserva creada o null si hubo un error (no deberia pasar)
     */ 
    private function crearReserva($fecha, $fechaHoraDesde, $fechaHoraHasta,Persona $persona, Zona $cancha, $precio=null, $senia=null) : Reserva
    {
        return Reserva::create([
            'observacion'        => null,
            'fecha'              => $fecha,
            'hora_desde'         => $fechaHoraDesde,
            'hora_hasta'         => $fechaHoraHasta,
            'precio'             => $precio, // lo vas a calcular con tarifas más adelante
            'senia'              => $senia, // lo vas a calcular con tarifas más adelante
            'estado'             => 'Pendiente',
            'metodo_pago'        => 'Pendiente',
            'tipo_reserva'       => 'Interna',
            'cancelacion_motivo' => null,
            'creado_por'         => null, // metodo auth para insertar el id
            'rela_persona'       => $persona->id,
            'rela_zona'          => $cancha->id,
        ]);
    }

    /**
     * Pagina para seleccionar la cancha y la sucursal
     * este es el segundo paso, una vez tenemos el cliente/persona
     * @param Persona $persona
     * @return \Illuminate\View\View
     * @todo Refactorizar codigo y elegir nombres apropiados
     */ 
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
     * este es el ultimo paso antes de crear la reserva
     * @param Persona $persona
     * @param Zona $cancha
     * @return \Illuminate\View\View
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

    public function preconfirmar(Request $request, Persona $persona, Zona $cancha)
    {
        // Validaciones básicas
        $request->validate([
            'fecha'       => 'required|date|after_or_equal:today',
            'hora_desde'  => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            'hora_hasta'  => 'required|regex:/^\d{2}:\d{2}(:\d{2})?$/',
        ], [
            'fecha.after' => 'La fecha no puede ser una pasada.',
            'hora_desde.required' => 'La hora de inicio es obligatoria.',
            'hora_hasta.required' => 'La hora de fin es obligatoria.',
            'hora_desde.regex' => 'El formato de hora de inicio debe ser valido HH:MM o HH:MM:SS.',
            'hora_hasta.regex' => 'El formato de hora de inicio debe ser valido HH:MM o HH:MM:SS.',
        ]);

        // Formateamos las horas a HH:MM:SS
        $horaDesde = Carbon::parse($request->input('hora_desde'))->format('H:i:s');
        $horaHasta = Carbon::parse($request->input('hora_hasta'))->format('H:i:s');
        $fecha = $request->input('fecha');

        // Verificamos disponibilidad
        if (!$this->horarioEstaDisponible(
            $fecha,
            $horaDesde, 
            $horaHasta, 
            $cancha
            )
        ) {
            // si esta ocupado volvermos con error
            return back()->withErrors(['El horario seleccionado no está disponible. Por favor, elija otro.']);
        }

        //si paso toda la validacion creamos los objetos datetime
        $desde = Carbon::parse("{$fecha} {$horaDesde}");
        $hasta = Carbon::parse("{$fecha} {$horaHasta}");

        // Si horaHasta es menor que horaDesde, asumimos que es del día siguiente
        if ($hasta->lessThanOrEqualTo($desde)) {
            $hasta->addDay();
        }

        // Traemos la sucursal de la cancha
        $sucursal = $cancha->sucursales()->first();

        // mostramos la preconfirmacion con toda la informacion relevante
        return view('reserva.preconfirmar', compact('persona', 'cancha', 'fecha', 'sucursal', 'desde', 'hasta', 'request'));
    }

    /**
     * Verifica si un horario está disponible para una cancha en una fecha.
     * Recibe horas en HH:MM y las formatea a HH:MM:SS internamente para la validacion.
     * @param string $fecha       Formato 'YYYY-MM-DD'
     * @param string $horaDesde   Formato 'HH:MM'
     * @param string $horaHasta   Formato 'HH:MM'
     * @param Cancha $cancha
     * @return bool
     */
    private function horarioEstaDisponible(string $fecha, string $horaDesde, string $horaHasta, Zona $cancha): bool
    {
        $desde = Carbon::parse("{$fecha} {$horaDesde}");
        $hasta = Carbon::parse("{$fecha} {$horaHasta}");

        // Si horaHasta es menor que horaDesde, asumimos que es del día siguiente
        if ($hasta->lessThanOrEqualTo($desde)) {
            $hasta->addDay();
        }

        $existeCruce = Reserva::where('rela_zona', $cancha->id)
            ->where('hora_desde', '<', $hasta)
            ->where('hora_hasta', '>', $desde)
            ->exists();

        return !$existeCruce;
    }

    public function testPreConfirmacion() {
        $request = new Request([
            "fecha" => "2025-09-01",
            "hora_desde" => "22:00:00",
            "hora_hasta" => "23:00:00",
        ]);
        

        $persona = Persona::find(1);
        $cancha = Zona::find(1);

        return $this->preconfirmar($request, $persona, $cancha);



    }

    //esta funcionando
    public function testDisponibilidadHoraria(){
        $fecha = '2025-09-02';
        $horaDesde = '00:30';
        $horaHasta = '01:30';
        $cancha = Zona::findOrFail(1);
        $disponible = $this->horarioEstaDisponible($fecha, $horaDesde, $horaHasta, $cancha);
        return $disponible ? '<h1>Disponible</h1>' : '<h1>No disponible</h1>';
    }

    public function verReservas()
    {
        // Traemos todas las reservas con persona y cancha cargadas
        $query = Reserva::query();
        $query->with(['persona', 'zona']);
        $reservas = $query->paginate(10);


        return view('reserva.ver_reservas', compact('reservas'));
    }

}
