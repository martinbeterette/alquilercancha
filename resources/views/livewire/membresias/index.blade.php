<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Membresías de {{ $complejo->nombre }}
    </h1>

    <!-- Buscador y botón crear -->
    <div class="flex justify-between items-center">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Buscar membresía..." 
            class="border rounded-lg px-3 py-2 w-1/3"
        />

        <flux:modal.trigger name="membresia-modal">
            <flux:button variant="primary" wire:click="crearMembresia">
                Crear Membresía
            </flux:button>
        </flux:modal.trigger>
    </div>

    <!-- Listado de membresías -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($membresias as $m)
            <div class="bg-white shadow rounded-2xl p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $m->nombre }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ $m->descripcion }}</p>

                    @if($m->precioConDescuento() < $m->precio)
                        <p class="text-gray-500 text-sm line-through">
                            ${{ number_format($m->precio, 0, ',', '.') }}
                        </p>
                    @endif

                    <div class="mt-0.5 flex">
                        <p class="text-lg font-bold text-green-600 mr-1">
                            ${{ number_format($m->precioConDescuento(), 0, ',', '.') }}
                        </p>

                        @if($m->precioConDescuento() < $m->precio)
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded">
                                {{ round((1 - $m->precioConDescuento() / $m->precio) * 100) }}% OFF
                            </span>
                        @endif
                    </div>
                </div>

                @php
                    $promo = $m->promociones()
                        ->where('activo', true)
                        ->whereDate('fecha_inicio', '<=', now())
                        ->whereDate('fecha_fin', '>=', now())
                        ->first();
                @endphp

                @if($promo)
                    <div class="mt-3 mb-3 text-sm text-blue-600">
                        🎉 {{ $promo->nombre }}:
                        @if($promo->tipo_descuento === 'porcentaje')
                            -{{ $promo->valor_descuento }}%
                        @else
                            -${{ number_format($promo->valor_descuento, 0, ',', '.') }}
                        @endif
                    </div>
                @endif

                <div class="mt-1 flex flex-col gap-1">
                    <flux:modal.trigger name="membresia-modal">
                        <flux:button variant="primary" wire:click="editarMembresia({{ $m->id }})">
                            Editar Membresía
                        </flux:button>
                    </flux:modal.trigger>

                    <flux:modal.trigger name="membresia-eliminar">
                        <flux:button variant="danger" wire:click="confirmarEliminacionMembresia({{ $m->id }})" class="mt-2">
                            Eliminar Membresía
                        </flux:button>
                    </flux:modal.trigger>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No se encontraron membresías.</p>
        @endforelse
    </div>

    <!-- Modal Flux Crear/Editar -->
    <flux:modal name="membresia-modal" size="lg">
        <div class="p-6">
            <h2 class="text-xl text-black font-bold mb-4">
                {{ $membresia->exists ? 'Editar Membresía' : 'Crear Membresía' }}
            </h2>

            <!-- Formulario Membresía -->
            <div class="space-y-4">
                <div>
                    <label class="block font-medium text-gray-700">Nombre</label>
                    <input type="text" wire:model.defer="nombre" class="border rounded px-3 py-2 w-full text-black" placeholder="Nombre de la membresía">
                    @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Descripción</label>
                    <textarea wire:model.defer="descripcion" class="border rounded px-3 py-2 w-full text-black" placeholder="Beneficios que tendra la membresía"></textarea>
                    @error('descripcion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-medium text-gray-700">Precio</label>
                        <input type="number" wire:model.defer="precio" class="border rounded px-3 py-2 w-full text-black">
                        @error('precio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block font-medium text-gray-700">Descuento Base (%)</label>
                        <input type="number" wire:model.defer="descuento_base" class="border rounded px-3 py-2 w-full text-black">
                        @error('descuento_base') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Promociones -->
                <div class="mt-4">
                    <h3 class="font-semibold mb-2 text-black">Promociones</h3>

                    @foreach($promociones as $index => $promo)
                        <div class="border p-3 rounded mb-2 relative">
                            <flux:modal.trigger name="confirmar-delete">
                                <button type="button" 
                                    wire:click="confirmarEliminacion({{ $index }})"
                                    class="absolute top-2 right-2 text-red-500 font-bold">
                                    &times;
                                </button>
                            </flux:modal.trigger>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm text-black">Nombre</label>
                                    <input type="text" wire:model.defer="promociones.{{ $index }}.nombre" class="border rounded px-2 py-1 w-full text-black" placeholder="Nombre de la promoción">
                                    @error("promociones.$index.nombre") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm text-black">Tipo Descuento</label>
                                    <select wire:model.defer="promociones.{{ $index }}.tipo_descuento" class="border rounded px-2 py-1 w-full text-black">
                                        <option value="porcentaje">Porcentaje</option>
                                        <option value="monto_fijo">Monto Fijo</option>
                                    </select>
                                    @error("promociones.$index.tipo_descuento") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 mt-2">
                                <div>
                                    <label class="block text-sm text-black">Valor</label>
                                    <input type="number" wire:model.defer="promociones.{{ $index }}.valor_descuento" class="border rounded px-2 py-1 w-full text-black">
                                    @error("promociones.$index.valor_descuento") <span class="text-red-500 text-xs">Valor de Descuento Necesario</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm text-black">Fecha Inicio</label>
                                    <input type="date" wire:model.defer="promociones.{{ $index }}.fecha_inicio" class="text-black border rounded px-2 py-1 w-full">
                                    @error("promociones.$index.fecha_inicio") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm text-black">Fecha Fin</label>
                                    <input type="date" wire:model.defer="promociones.{{ $index }}.fecha_fin" class="border rounded px-2 py-1 w-full text-black">
                                    @error("promociones.$index.fecha_fin") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-2 flex items-center">
                                <div class="flex items-center gap-2">
                                    @if($promociones[$index]['activo'])
                                        <flux:button 
                                            wire:click="toggleActivo({{ $index }})" 
                                            variant="danger"
                                            size="sm"
                                        >
                                            Desactivar
                                        </flux:button>
                                    @else
                                        <flux:button 
                                            wire:click="toggleActivo({{ $index }})" 
                                            variant="primary"
                                            size="sm"
                                            class="text-blue-500 border"
                                        >
                                            Activar
                                        </flux:button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <flux:button variant="primary" type="button" wire:click="addPromocion" class="text-red-500 border">Agregar Promoción</flux:button>
                </div>

                <!-- Botones Guardar/Cancelar -->
                <div class="mt-4 flex justify-end gap-3">
                    <flux:modal.close>
                        <flux:button variant="ghost" class="text-black border">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button variant="primary" wire:click="guardar" wire:loading.attr="disabled" class="text-blue-600">
                        <span wire:loading>Guardando...</span>
                        <span wire:loading.remove>Guardar</span>
                    </flux:button>
                </div>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Confirmar Eliminación Promocion --}}
    <flux:modal name="confirmar-delete" size="sm">
        <div class="p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-800">¿Eliminar promoción?</h2>
            <p class="text-gray-600">Esta seguro de realizar esta acción que eliminira la promoción</p>

            <div class="flex justify-end gap-3 mt-4">
                <flux:modal.close>
                    <flux:button variant="ghost" class="text-black border">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button 
                    variant="danger" 
                    wire:click="eliminarPromocionConfirmada">
                    Eliminar
                </flux:button>
            </div>
        </div>
    </flux:modal>

    {{-- Modal Confirmar Eliminación Membresia --}}
    <flux:modal name="membresia-eliminar" size="sm">
        <div class="p-6 space-y-4">
            <h2 class="text-lg font-bold text-gray-800">¿Eliminar Membresia?</h2>
            <p class="text-gray-600">Esta seguro de realizar esta acción que eliminira la Membresia y Promociones relacionadas a ella</p>

            <div class="flex justify-end gap-3 mt-4">
                <flux:modal.close>
                    <flux:button variant="ghost" class="text-black border">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button 
                    variant="danger" 
                    wire:click="eliminarMembresiaConfirmada">
                    Eliminar
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>
