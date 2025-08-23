<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class DataTable extends Component
{
    use WithPagination;

    // Parámetros configurables
    public $model;         // Clase del modelo Eloquent (ej: App\Models\User)
    public $columns = [];  // Definición de columnas [ 'id' => 'ID', 'name' => 'Nombre', ... ]
    public $search = '';   // Cadena de búsqueda
    public $sortField = 'id';      // Campo inicial para ordenamiento
    public $sortDirection = 'asc'; // Dirección por defecto
    public $perPage = 10;          // Registros por página

    // El método mount se ejecuta al inicializar el componente
    public function mount($model, $columns)
    {
        $this->model = $model;
        $this->columns = $columns;
    }

    // Se ejecuta cada vez que se actualiza el valor de "search"
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Método para manejar cambios en el ordenamiento
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            // Invierte la dirección al hacer clic de nuevo en el mismo campo
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    // Construye la consulta y retorna la vista con los datos
    public function render()
    {
        // Se asume que $model es la clase completa del modelo (por ejemplo, App\Models\User)
        $modelClass = $this->model;
        $query = $modelClass::query();

        // Agrega búsqueda dinámica en las columnas definidas
        if ($this->search !== '') {
            $query->where(function (Builder $q) {
                foreach (array_keys($this->columns) as $column) {
                    $q->orWhere($column, 'like', '%' . $this->search . '%');
                }
            });
        }

        // Aplica ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);

        // Paginación de resultados
        $data = $query->paginate($this->perPage);

        // Se pasan explícitamente 'data' y 'columns' a la vista
        return view('livewire.data-table', [
            'data'    => $data,
            'columns' => $this->columns
        ]);
    }
}
