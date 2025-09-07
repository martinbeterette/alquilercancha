<div class="space-y-4">
    {{-- Barra superior --}}
    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold">Cargos de Empleados</h2>

        {{-- Botón Crear --}}
        <flux:modal.trigger name="cargo-modal">
            <flux:button variant="primary" wire:click="abrirCrear">
                Nuevo Cargo
            </flux:button>
        </flux:modal.trigger>
    </div>

    {{-- Tabla --}}
    <table class="min-w-full bg-white shadow rounded">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 text-left">ID</th>
                <th class="p-2 text-left">Descripción</th>
                <th class="p-2 text-left">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cargos as $cargo)
                <tr class="border-b">
                    <td class="p-2">{{ $cargo->id }}</td>
                    <td class="p-2">{{ $cargo->descripcion }}</td>
                    <td class="p-2 flex gap-2">
                        {{-- Editar --}}
                        <flux:modal.trigger name="cargo-modal">
                            <flux:button
                                variant="primary"
                                size="sm"
                                wire:click="abrirEditar({{ $cargo->id }})">
                                Editar
                            </flux:button>
                        </flux:modal.trigger>

                        {{-- Eliminar --}}
                        <flux:button
                            variant="danger"
                            size="sm"
                            wire:click="eliminar({{ $cargo->id }})">
                            Eliminar
                        </flux:button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No se encontraron cargos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="mt-2">
        {{ $cargos->links() }}
    </div>

    {{-- Modal para crear/editar --}}
    <flux:modal name="cargo-modal" class="md:w-96" wire:ignore.self>
        <div class="space-y-6">
            <flux:heading size="lg">
                {{ $cargoSeleccionado->exists ? 'Editar Cargo' : 'Crear Cargo' }}
            </flux:heading>

            {{-- Input Descripción --}}
            <flux:input
                label="Descripción"
                placeholder="Nombre del cargo"
                wire:model.defer="descripcion"
            />
            @error('descripcion') 
                <span class="text-red-500 text-sm">{{ $message }}</span> 
            @enderror

            {{-- Botones --}}
            <div class="flex justify-end gap-2 mt-4">
                {{-- Cancelar --}}
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                {{-- Guardar/Actualizar --}}
                <flux:button variant="primary" wire:click="guardar">
                    {{ $cargoSeleccionado->exists ? 'Actualizar' : 'Guardar' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
