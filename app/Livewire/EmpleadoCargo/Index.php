<?php

namespace App\Livewire\EmpleadoCargo;

use App\Models\EmpleadoCargo;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public EmpleadoCargo $cargoSeleccionado;
    public $descripcion;

    protected $rules = [
        'descripcion' => 'required|string|min:3|max:50',
    ];

    public function mount()
    {
        $this->resetCargo();
    }

    private function resetCargo()
    {
        $this->cargoSeleccionado = new EmpleadoCargo();
        $this->descripcion = '';
    }

    public function abrirCrear()
    {
        $this->resetCargo();
        $this->dispatch('open-flux-modal', name: 'cargo-modal');
    }

    public function abrirEditar(EmpleadoCargo $cargo)
    {
        $this->cargoSeleccionado = $cargo;
        $this->descripcion = $cargo->descripcion;
        $this->dispatch('open-flux-modal', name: 'cargo-modal');
    }

    public function guardar()
    {
        $this->validate();

        if ($this->cargoSeleccionado->exists) {
            $this->cargoSeleccionado->update([
                'descripcion' => $this->descripcion,
            ]);
        } else {
            EmpleadoCargo::create([
                'descripcion' => $this->descripcion,
            ]);
        }

        // Reset antes de cerrar modal
        $this->resetCargo();

        // Cerrar modal de manera confiable
        $this->dispatch('close-flux-modal', name: 'cargo-modal');

        // Refrescar la página de Livewire para ver cambios
        $this->resetPage();
    }

    public function eliminar(EmpleadoCargo $cargo)
    {
        $cargo->delete();
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.empleado-cargo.index', [
            'cargos' => EmpleadoCargo::paginate(10),
        ]);
    }
}
