<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    public $user, $usuario, $email, $contrasena, $confirm_contrasena, $allRoles;
    public $roles = [];

    public function mount($id){
        $this->user = User::find($id);
        $this->usuario = $this->user->name;
        $this->email = $this->user->email;
        $this->allRoles = Role::all();
        $this->roles = $this->user->roles()->pluck("name");
    }

    public function render()
    {
        return view('livewire.users.user-edit');
    }

    public function submit()
    {
        $this->validate([
            "usuario" => "required",
            "email" => "required|email",
            "contrasena" => "same:confirm_contrasena"
        ]);

        $this->user->name = $this->usuario;
        $this->user->email = $this->email;

        if($this->contrasena) {
            $this->user->password = Hash::make($this->contrasena);
        }

        $this->user->save();

        $this->user->syncRoles($this->roles);

        return to_route("users.index")->with("success", "Usuario Editado");
    }
}
