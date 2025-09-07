<?php

namespace App\Livewire\Empleados;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Empleado;
use App\Models\EmpleadoCargo;

class EmpleadoIndex extends Component
{
    use WithPagination;

    // Layout
    public function layout(): string
    {
        return 'base';
    }

    // Estado del formulario
    public $empleadoSeleccionado = null;
    public $nombre = '';
    public $cargo_id = '';

    // Estado de búsqueda y paginación
    public $search = '';
    public int $perPage = 10;

    protected $rules = [
        'nombre'   => 'required|string|max:255',
        'cargo_id' => 'nullable|exists:empleado_cargos,id',
    ];

    // Reset paginación al cambiar búsqueda
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Computed: Empleados y Cargos
    public function getEmpleadosProperty()
    {
        return Empleado::with('cargo')
            ->where('user_id', 'like', "%{$this->search}%")
            ->orWhereHas('cargo', fn($q) => $q->where('descripcion', 'like', "%{$this->search}%"))
            ->paginate($this->perPage);
    }

    public function getCargosProperty()
    {
        return EmpleadoCargo::all();
    }

    // Abrir modal para crear
    public function abrirCrear()
    {
        $this->reset(['empleadoSeleccionado', 'nombre', 'cargo_id']);
    }

    // Abrir modal para editar
    public function abrirEditar($id)
    {
        $empleado = Empleado::findOrFail($id);
        $this->empleadoSeleccionado = $empleado;
        $this->nombre = $empleado->nombre;
        $this->cargo_id = $empleado->cargo_id;
    }

    // Guardar (crear o actualizar)
    public function guardar()
    {
        $this->validate();

        if ($this->empleadoSeleccionado) {
            $this->empleadoSeleccionado->update([
                'nombre' => $this->nombre,
                'cargo_id' => $this->cargo_id,
            ]);
        } else {
            Empleado::create([
                'nombre' => $this->nombre,
                'cargo_id' => $this->cargo_id,
            ]);
        }

        $this->reset(['empleadoSeleccionado', 'nombre', 'cargo_id']);

        // Opcional: cerrar modal automáticamente después de guardar
        $this->dispatch('close-flux-modal', name: 'empleado-modal');
    }

    // Eliminar
    public function eliminar(Empleado $empleado)
    {
        $empleado->delete();
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.empleados.index');
    }
}
