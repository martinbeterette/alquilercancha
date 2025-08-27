<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role; // 👈 Importa el modelo de roles

class UserIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $roleFilter = ''; // 👈 Nuevo filtro de rol
    public $roles = [];      // 👈 Para llenar el select
    public int $perPage = 1; // cantidad de registros por página

    protected array $perPageOptions = [1, 2, 3];    
    protected $allowedSorts = ['id', 'name', 'email'];
    protected $paginationTheme = 'tailwind'; // estilos de tailwind

    public function mount()
    {
        $this->roles = Role::all(); // 👈 Cargamos los roles disponibles
    }

    public function updatingRoleFilter() 
    { 
        $this->resetPage(); // 👈 reset al cambiar rol
    }

    public function updatingSearch()
    {
        $this->resetPage(); // reinicia paginación al buscar
    }

    public function updatingPerPage($value)
    {
         // casteo + validación (evita valores raros y asegura int)
        $value = (int) $value;
        $this->perPage = in_array($value, $this->perPageOptions) ? $value : $this->perPageOptions[0];
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($id)
    {
        if ($user = User::find($id)) {
            $user->delete();
            session()->flash("success", "Usuario Eliminado");
        } else {
            session()->flash("error", "El usuario no existe.");
        }
    }

    public function render()
    {
        $sortField = in_array($this->sortField, $this->allowedSorts) 
            ? $this->sortField 
            : 'id';

        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->when($this->roleFilter, function ($query) {
                $query->whereHas('roles', fn($q) => $q->where('name', $this->roleFilter));
            }) // 👈 Aplica el filtro solo si hay rol seleccionado
            ->orderBy($sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.users.user-index', compact("users"));
    }
}
