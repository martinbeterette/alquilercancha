<div class="space-y-4">
    @section('content')
     Empleados de tincho
    @endsection
    {{-- Barra de búsqueda --}}
    <div class="flex justify-between items-center">
        <flux:input 
            placeholder="Buscar empleado o cargo..." 
            wire:model.live="search" 
            class="w-1/3"
        />

        {{-- Botón para crear --}}
        <flux:modal.trigger name="empleado-modal">
            <flux:button variant="primary" wire:click="abrirCrear">
                Nuevo Empleado
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Tabla --}}
    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Nombre</th>
                <th class="p-2">Cargo</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($this->empleados as $empleado)
                <tr class="border-b">
                    <td class="p-2">{{ $empleado->nombre }}</td>
                    <td class="p-2">{{ $empleado->cargo?->descripcion }}</td>
                    <td class="p-2 space-x-2">
                        <flux:modal.trigger name="empleado-modal" wire:click="abrirEditar({{ $empleado->id }})">
                            <flux:button variant="ghost" size="sm">
                                Editar
                            </flux:button>
                        </flux:modal.trigger>

                        <flux:button variant="destructive" size="sm" wire:click="eliminar({{ $empleado->id }})">
                            Eliminar
                        </flux:button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No se encontraron empleados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div>
        {{ $this->empleados->links() }}
    </div>

    {{-- Modal único (crear/editar) --}}
    <flux:modal name="empleado-modal" class="md:w-96">
        <flux:heading size="lg">
            {{ $empleadoSeleccionado ? 'Editar Empleado' : 'Crear Empleado' }}
        </flux:heading>

        <flux:input label="Nombre" placeholder="Nombre del empleado" wire:model="nombre" />

        <label class="block">
            Cargo
            <select wire:model="cargo_id" class="w-full p-2 border rounded mt-1">
                <option value="">Seleccione Cargo</option>
                @foreach($this->cargos as $cargo)
                    <option value="{{ $cargo->id }}">{{ $cargo->descripcion }}</option>
                @endforeach
            </select>
        </label>

        <div class="flex justify-end gap-2">
            <flux:modal.close>
                <flux:button variant="ghost">Cancelar</flux:button>
            </flux:modal.close>

            <flux:button variant="primary" wire:click="guardar">
                {{ $empleadoSeleccionado ? 'Actualizar' : 'Guardar' }}
            </flux:button>
        </div>
    </flux:modal>

    <flux:modal.trigger name="delete-profile">
        <flux:button variant="danger">Delete</flux:button>
    </flux:modal.trigger>

    <flux:modal name="delete-profile" class="min-w-[22rem]">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Delete project?</flux:heading>

                <flux:text class="mt-2">
                    <p>You're about to delete this project.</p>
                    <p>This action cannot be reversed.</p>
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="danger">Delete project</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
