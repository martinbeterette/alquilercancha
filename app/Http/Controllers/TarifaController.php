<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use Illuminate\Http\Request;

use App\Models\Sucursal;

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
    public function create()
    {
        return "create tarifa";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return "store tarifa";
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
}
