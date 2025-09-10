<?php

namespace App\Http\Controllers;

use App\Http\Requests\TarifaStoreRequest;
use App\Models\Tarifa;
use Illuminate\Http\Request;

use App\Models\Sucursal;
use Carbon\Carbon;

class TarifaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Sucursal $sucursal)
    {   
        $perPage = $request->input('per_page', 5);
        $tarifas = $sucursal->tarifas()->paginate($perPage);
        return view('tarifa.index', compact('sucursal', 'tarifas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Sucursal $sucursal, Tarifa $tarifa)
    {
        return view('tarifa.create', compact('sucursal', 'tarifa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TarifaStoreRequest $request, Sucursal $sucursal)
    {
        $request->validated();
        $horaDesde = Carbon::parse($request->input('hora-desde'))->format('H:i:s');
        $horaHasta = Carbon::parse($request->input('hora-hasta'))->format('H:i:s');

        //aca iria una validacion de que no se crucen las tarifas
        if ($this->tarifaEstaPisada($horaDesde, $horaHasta, $sucursal->id)) {
            return redirect()->back()
                ->withErrors(["La tarifa se superpone a otra existente"])
                ->withInput();
        }

        $tarifa = $sucursal->tarifas()->create([
            "nombre"        => $request->nombre,
            "hora_desde"    => $horaDesde,
            "hora_hasta"    => $horaHasta,
            "precio"        => $request->precio,
        ]);

        return redirect()->route('sucursal.tarifa.index', $sucursal)->with('success', "Registro creado con exito");

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sucursal $sucursal, Tarifa $tarifa)
    {
        return view('tarifa.edit', compact('sucursal', 'tarifa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TarifaStoreRequest $request, Sucursal $sucursal, Tarifa $tarifa)
    {
        $request->validated();
        $horaDesde = Carbon::parse($request->input('hora-desde'))->format('H:i:s');
        $horaHasta = Carbon::parse($request->input('hora-hasta'))->format('H:i:s');
        //aca iria una validacion de que no se crucen las tarifas
        if ($this->tarifaEstaPisada($horaDesde, $horaHasta, $sucursal->id, $tarifa->id)) {
            return redirect()->back()
                ->withErrors(["La tarifa se superpone a otra existente"])
                ->withInput();
        }

        $tarifa->update([
            "nombre"        => $request->nombre,
            "hora_desde"    => $horaDesde,
            "hora_hasta"    => $horaHasta,
            "precio"        => $request->precio,
        ]);

        return redirect()->route('sucursal.tarifa.index', $sucursal)->with('success', "Registro actualizado con exito");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sucursal $sucursal, Tarifa $tarifa)
    {
        $tarifa->delete();
        return redirect()->route('sucursal.tarifa.index', $sucursal)
                         ->with('success', 'Tarifa eliminada exitosamente.');
    }

    private function tarifaEstaPisada($horaDesde, $horaHasta, $sucursalId, $tarifaId = null) {
        // Convertir horas a segundos
        $horaInicioSeg  = $this->horaEnSegundos($horaDesde);
        $horaFinSeg     = $this->horaEnSegundos($horaHasta);

        // Obtener todas las tarifas de la sucursal
        $query = Tarifa::where('rela_sucursal', $sucursalId);
        if ($tarifaId){
            $query->where('id', '!=', $tarifaId);
        }
        $tarifas = $query->get();
        foreach ($tarifas as $t) {
            // Convertir horas de la tarifa existente a segundos
            $tInicio    = $this->horaEnSegundos($t->hora_desde);
            $tFin       = $this->horaEnSegundos($t->hora_hasta);

            // Normalizar rangos para manejar cruce de medianoche
            $nuevoInicio = $horaInicioSeg;
            $nuevoFin = $horaFinSeg;
            $existenteInicio = $tInicio;
            $existenteFin = $tFin;

            // Ajustar si la nueva tarifa cruza medianoche
            if ($nuevoFin < $nuevoInicio) {
                $nuevoFin += 86400; // Sumar 24 horas en segundos
            }
            // Ajustar si la tarifa existente cruza medianoche
            if ($tFin < $tInicio) {
                $existenteFin += 86400; // Sumar 24 horas en segundos
            }

            // Verificar solapamiento (usando < y > para permitir que se toquen)
            if ($nuevoInicio < $existenteFin && $nuevoFin > $existenteInicio) {
                return true; // Hay solapamiento
            }
        }

        return false; // No hay solapamiento
    }

    private function horaEnSegundos($hora) {
        [$h, $m, $s] = explode(':', $hora);
        return $h * 3600 + $m * 60 + $s;
    }

    public function testTarifaPisada()
    {
        // Parámetros "fijos" para testear
        $horaDesde = '23:59:00';
        $horaHasta = '00:00:00';

        // Supongamos que queremos testear para la sucursal con id 1
        $sucursalId = 1;

        if ($this->tarifaEstaPisada($horaDesde, $horaHasta, $sucursalId)) {
            return "⚠️ La tarifa se superpone con otra existente";
        }

        return "✅ La tarifa NO se superpone, se puede crear";
    }
}
