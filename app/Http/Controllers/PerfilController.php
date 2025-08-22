<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil as Rol; // Alias para evitar confusiones

class PerfilController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('tablasMaestras.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('tablasMaestras.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:20',
        ]);

        Rol::create([
            'name' => $request->name,
            'guard_name' => 'web', // o el guard que uses
        ]);

        return redirect()->route('roles.index');
    }

    public function edit(Rol $rol)
    {
        return view('tablasMaestras.roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'name' => 'required|max:20|unique:roles,name,' . $rol->id,
        ]);

        $rol->update($request->only('name'));

        return redirect()->route('roles.index');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('roles.index');
    }
}
