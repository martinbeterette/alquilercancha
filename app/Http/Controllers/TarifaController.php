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
        $horaHasta = Carbon::parse($request->input('hora_hasta'))->format('H:i:s');
        //aca iria una validacion de que no se crucen las tarifas
        if ($this->tarifaEstaPisada($horaDesde, $horaHasta, $sucursal->id)) {
            return redirect()->route('sucursal.tarifa.index', $sucursal)->withErrors(["La tarifa se superpone a otra existente"]);
        }

        $tarifa = $sucursal->tarifas()->create([
            "nombre" => $request->nombre,
            "hora_desde" => $horaDesde,
            "hora_hasta" => $horaHasta,
            "precio" => $request->precio,
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
        return "editar tarifa";

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sucursal $sucursal, Tarifa $tarifa)
    {
        return "updatear tarifa";
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

    private function tarifaEstaPisada($horaDesde, $horaHasta, $sucursalId) {


        return Tarifa::where('rela_sucursal', $sucursalId)
            ->where(function($query) use ($horaDesde, $horaHasta) {
                $query->whereBetween('hora_desde', [$horaDesde, $horaHasta])
                    ->orWhereBetween('hora_hasta', [$horaDesde, $horaHasta])
                    ->orWhere(function($q) use ($horaDesde, $horaHasta) {
                        $q->where('hora_desde', '<=', $horaDesde)
                            ->where('hora_hasta', '>=', $horaHasta);
                    });
            })
            ->exists();
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
