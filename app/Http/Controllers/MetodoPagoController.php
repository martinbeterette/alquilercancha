<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = MetodoPago::query();

        // Búsqueda por descripción
        if ($search = $request->input('search')) {
            $query->where('descripcion', 'like', "%{$search}%")
                  ->orWhere('id', 'like', "%{$search}%");
        }

        // Paginación 10 por página
        $metodosPago = $query->paginate(5);

        // Retornamos la vista con los resultados
        return view('tablasMaestras.metodo_pago.index', compact('metodosPago'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tablasMaestras.metodo_pago.create');
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

        MetodoPago::create($validated);

        return redirect()->route('metodo_pago.index')
                        ->with('success', 'Método de pago creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MetodoPago $metodoPago)
    {
        return redirect()->route('metodo_pago.index')->with('error', 'No se puede mostrar un método de pago individualmente.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MetodoPago $metodoPago)
    {
        return view('tablasMaestras.metodo_pago.edit', compact('metodoPago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MetodoPago $metodoPago)
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
        $metodoPago->update($validated);

        // Redirigir con mensaje
        return redirect()->route('metodo_pago.index')
                        ->with('success', 'Método de pago actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MetodoPago $metodoPago)
    {
        $metodoPago->delete();

        return redirect()->route('metodo_pago.index')
                         ->with('success', 'Método de pago eliminado correctamente.');
    }
}
