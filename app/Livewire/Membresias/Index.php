<?php

namespace App\Livewire\Membresias;


use Livewire\Component;
use App\Models\Complejo;
use App\Models\Membresia;
use App\Models\Promocion;
use Flux\Flux;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $complejo;
    public $search = '';

    // Formulario membresía
    public Membresia $membresia;
    public $nombre = '';
    public $descripcion = '';
    public $precio = 0;
    public $descuento_base = 0;
    public $membresiaAEliminar = null;

    // Formulario promociones
    public $promociones = [];

    // Para manejar el modal de confirmación
    public $promoAEliminar = null;
    public $showConfirmDelete = false;

    // Spinner
    public $loading = false;

    protected $rules = [
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
        'descuento_base' => 'nullable|integer|min:0|max:100',
        'promociones.*.nombre' => 'required|string|max:255',
        'promociones.*.tipo_descuento' => 'required|in:porcentaje,monto_fijo',
        'promociones.*.valor_descuento' => 'required|numeric|min:0',
        'promociones.*.fecha_inicio' => 'required|date',
        'promociones.*.fecha_fin' => 'required|date|after_or_equal:promociones.*.fecha_inicio',
    ];

    public function mount(Complejo $complejo)
    {
        $this->complejo = $complejo;
        $this->resetForm();
    }

    /** Abrir modal para crear membresía */
    public function crearMembresia()
    {
        $this->resetForm();
    }

    /** Abrir modal para editar membresía */
    public function editarMembresia($id)
    {
        $this->membresia = Membresia::with('promociones')->findOrFail($id);

        $this->nombre = $this->membresia->nombre;
        $this->descripcion = $this->membresia->descripcion;
        $this->precio = $this->membresia->precio;
        $this->descuento_base = $this->membresia->descuento_base;

        // Cargar promociones existentes
        $this->promociones = $this->membresia->promociones->map(function($p){
            return [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'descripcion' => $p->descripcion,
                'tipo_descuento' => $p->tipo_descuento,
                'valor_descuento' => $p->valor_descuento,
                'fecha_inicio' => $p->fecha_inicio->format('Y-m-d'),
                'fecha_fin' => $p->fecha_fin->format('Y-m-d'),
                'activo' => $p->activo,
            ];
        })->toArray();
    }

    /** Abrir modal para confirmar eliminación de membresía */
    public function confirmarEliminacionMembresia($id)
    {
        $this->membresiaAEliminar = Membresia::findOrFail($id);
    }

    /** Ejecutar eliminación después de confirmar */
    public function eliminarMembresiaConfirmada()
    {
        if ($this->membresiaAEliminar) {
            DB::transaction(function () {
                // Soft delete de promociones asociadas
                foreach ($this->membresiaAEliminar->promociones as $promo) {
                    $promo->delete();
                }

                // Soft delete de la membresía
                $this->membresiaAEliminar->delete();
            });

            $this->membresiaAEliminar = null;

            Flux::modal('membresia-eliminar')->close();

            $this->dispatch('toastr', type: 'success', message: 'La membresía y sus promociones fueron eliminadas correctamente!');
        }
    }

    /** Agregar promoción vacía */
    public function addPromocion()
    {
        $this->promociones[] = [
            'nombre' => '',
            'descripcion' => '',
            'tipo_descuento' => 'porcentaje',
            'valor_descuento' => 0,
            'fecha_inicio' => now()->format('Y-m-d'),
            'fecha_fin' => now()->addDays(7)->format('Y-m-d'),
            'activo' => true,
        ];
    }

    /** Eliminar promoción del formulario */
    public function removePromocion($index)
    {
        unset($this->promociones[$index]);
        $this->promociones = array_values($this->promociones);
    }

    public function confirmarEliminacion($index)
    {
        $this->promoAEliminar = $index;
    }

    /** Ejecutar eliminación después de confirmar */
    public function eliminarPromocionConfirmada()
    {
        if ($this->promoAEliminar === null) {
            return;
        }

        $index = $this->promoAEliminar;

        if (isset($this->promociones[$index])) {
            // Si existe en DB → soft delete
            if (!empty($this->promociones[$index]['id'])) {
                $promo = Promocion::find($this->promociones[$index]['id']);
                if ($promo) {
                    $promo->delete();
                }
            }

            // Eliminar del array en memoria
            unset($this->promociones[$index]);
            $this->promociones = array_values($this->promociones);
        }

        $this->promoAEliminar = null;
        
        Flux::modal('confirmar-delete')->close();

        $this->dispatch('toastr', type: 'success', message: 'La promocion fue eliminada correctamente!');
    }

    public function toggleActivo($index)
    {
        if (!isset($this->promociones[$index])) {
            return;
        }

        // Cambiar estado en el array
        $this->promociones[$index]['activo'] = !$this->promociones[$index]['activo'];

        // Si la promoción ya existe en BD, actualizar directamente
        if (!empty($this->promociones[$index]['id'])) {
            Promocion::where('id', $this->promociones[$index]['id'])
                ->update(['activo' => $this->promociones[$index]['activo']]);
        }

        $this->dispatch('toastr', type: 'success', message: 'El estado de la promoción fue actualizado correctamente!');
    }

    /** Guardar membresía y promociones */
    public function guardar()
    {
        $this->validate();

        $this->loading = true;

        DB::transaction(function () {
            // Normalizar descuento_base
            $this->descuento_base = ($this->descuento_base === null || $this->descuento_base === '') ? 0 : (int) $this->descuento_base;

            // Guardar membresía
            $this->membresia->nombre = $this->nombre;
            $this->membresia->descripcion = $this->descripcion;
            $this->membresia->precio = $this->precio;
            $this->membresia->descuento_base = $this->descuento_base;
            $this->membresia->complejo_id = $this->complejo->id;
            $this->membresia->save();

            // IDs de promos que siguen activas
            $idsEnFormulario = collect($this->promociones)->pluck('id')->filter()->toArray();

            // Eliminar promociones que ya no están
            $this->membresia->promociones()
                ->whereNotIn('id', $idsEnFormulario)
                ->delete();

            // Crear/Actualizar promociones
            foreach ($this->promociones as $promoData) {
                $this->membresia->promociones()->updateOrCreate(
                    ['id' => $promoData['id'] ?? null],
                    array_merge($promoData, [
                        'complejo_id' => $this->complejo->id,
                    ])
                );
            }
        });

        $this->loading = false;
        $this->resetForm();

        Flux::modal('membresia-modal')->close();

        $this->dispatch('toastr', type: 'success', message: 'Membresía y promociones guardadas correctamente!');
    }

    /** Reset formulario completo */
    public function resetForm()
    {
        $this->membresia = new Membresia();
        $this->nombre = '';
        $this->descripcion = '';
        $this->precio = 0;
        $this->descuento_base = 0;
        $this->promociones = [];
    }

    public function render()
    {
        $membresias = Membresia::where('complejo_id', $this->complejo->id)
            ->when($this->search, fn($q) =>
                $q->where('nombre', 'like', "%{$this->search}%")
            )
            ->with('promociones')
            ->get();

        return view('livewire.membresias.index', [
            'membresias' => $membresias,
            'complejo' => $this->complejo,
        ]);
    }
}
