<?php

namespace App\Http\Controllers;

use App\Models\EstadoPago;
use Illuminate\Http\Request;

class EstadoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EstadoPago::query();

        // Búsqueda por descripción
        if ($search = $request->input('search')) {
            $query->where('descripcion', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
        }

        // Paginación 10 por página
        $estadosPago = $query->paginate(5);

        // Retornamos la vista con los resultados
        return view('tablasMaestras.estado_pago.index', compact('estadosPago'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tablasMaestras.estado_pago.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z\s]+$/'],
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede tener más de 20 caracteres.',
            'descripcion.regex' => 'La descripción solo debe contener letras y espacios.',
        ]);

        EstadoPago::create($validated);

        return redirect()->route('estado_pago.index')
                        ->with('success', 'Estado de pago creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EstadoPago $estadoPago)
    {
        return redirect()->route('estado_pago.index')->with('error', 'No se puede mostrar un estado de pago individualmente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EstadoPago $estadoPago)
    {
        return view('tablasMaestras.estado_pago.edit', compact('estadoPago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EstadoPago $estadoPago)
    {
        // Validación
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:20', 'regex:/^[A-Za-z\s]+$/'],
        ], [
            'descripcion.required' => 'La descripción es obligatoria.',
            'descripcion.max' => 'La descripción no puede tener más de 20 caracteres.',
            'descripcion.regex' => 'La descripción solo debe contener letras y espacios.',
        ]);
        // Actualizar el registro
        $estadoPago->update($validated);

        // Redirigir con mensaje
        return redirect()->route('estado_pago.index')
                        ->with('success', 'Estado de pago actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoPago $estadoPago)
    {
        $estadoPago->delete();

        return redirect()->route('estado_pago.index')
                         ->with('success', 'Estado de pago eliminado correctamente.');
    }
}
