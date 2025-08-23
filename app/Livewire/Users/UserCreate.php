<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\CuentaReactivada;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public $usuario, $email, $contrasena, $confirm_contrasena, $allRoles;
    public $roles= [];

    public function mount()
    {
        $this->allRoles = Role::all();
    }

    public function render()
    {
        return view('livewire.users.user-create');
    }

    public function submit()
    {
        $this->validate([
            "usuario" => "required",
            "email" => "required|email",
            "roles" => "required",
            "contrasena" => "required|same:confirm_contrasena"
        ]);

        $user = User::withTrashed()->where("email", $this->email)->first();

        if ($user && $user->trashed()) {
            $user->restore();
            $user->update([
                "name" => $this->usuario,
                "password" => Hash::make($this->contrasena),
            ]);

            Mail::to($user->email)->send(new CuentaReactivada($user));

            return to_route("users.index")->with("success", "Cuenta reactivada, revisá tu email para confirmar");
        }

        $user = User::create([
            "name" => $this->usuario,
            "email" => $this->email,
            "password" => Hash::make($this->contrasena)
        ]);

        $user->syncRoles($this->roles);

        return to_route("users.index")->with("success", "Usuario creado");
    }
}