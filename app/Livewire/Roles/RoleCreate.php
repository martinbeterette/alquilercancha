<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleCreate extends Component
{
    public $role;
    public $allpermissions = [];
    public $permissions = [];

    public function mount()
    {
        $this -> allpermissions = Permission::get();
    }

    public function render()
    {    
        return view('livewire.roles.role-create');
    }

    public function submit()
    {
        $this->validate([
            "role" => "required|unique:roles,name",
            "permissions" => "required",
        ]);

        $role = Role::create([
            'name' => $this->role
        ]);

        $role->syncPermissions($this->permissions);

        return to_route("roles.index")->with("success", "Role creado");
    }
}
