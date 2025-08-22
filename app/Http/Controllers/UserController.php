<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get(); // trae todos los usuarios con roles
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); // todos los roles disponibles
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', 
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ]);

        // Asignar roles
        if ($request->roles) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $user)
    {
        $roles = Role::all(); // todos los roles disponibles
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name',
        ]);

        
        $user->update($request->only('name', 'email'));

        $user->syncRoles($request->roles ?? []); 

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

}
