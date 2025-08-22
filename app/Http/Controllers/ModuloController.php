<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modulo;
use App\Models\Perfil; 

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modulos = Modulo::with('roles')->get(); // trae todos los módulos con sus roles
        return view('tablasMaestras.modulos.index', compact('modulos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Perfil::all(); // todos los roles disponibles
        return view('tablasMaestras.modulos.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'slug' => 'required|string|max:20|unique:modulos,slug',
            'icon' => 'nullable|string|max:20',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id', // usamos IDs porque es más simple para el create
        ]);

        // Crear módulo
        $modulo = Modulo::create($request->only('name', 'slug', 'icon'));

        // Asignar roles si hay
        if ($request->roles) {
            $modulo->roles()->attach($request->roles); // attach con IDs
        }

        return redirect()->route('modulos.index')->with('success', 'Módulo creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modulo $modulo)
    {
        $roles = Perfil::all(); // todos los roles
        return view('tablasMaestras.modulos.edit', compact('modulo', 'roles'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modulo $modulo)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'slug' => 'required|string|max:20|unique:modulos,slug,' . $modulo->id,
            'icon' => 'nullable|string|max:20',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Actualizar datos básicos
        $modulo->update($request->only('name', 'slug', 'icon'));

        // Sincronizar roles asignados
        $modulo->roles()->sync($request->roles ?? []);

        return redirect()->route('modulos.index')->with('success', 'Módulo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modulo $modulo)
    {
        $modulo->delete();
        return redirect()->route('modulos.index')->with('success', 'Módulo eliminado correctamente');
    }
}
