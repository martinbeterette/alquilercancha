<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Membresías de {{ $complejo->nombre }}
    </h1>

    <!-- Buscador -->
    <div class="flex justify-between items-center">
        <input 
            type="text" 
            wire:model.live="search" 
            placeholder="Buscar membresía..." 
            class="border rounded-lg px-3 py-2 w-1/3"
        />
    </div>

    <!-- Listado de membresías -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($membresias as $m)
            <div class="bg-white shadow rounded-2xl p-4 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $m->nombre }}</h2>
                    <p class="text-gray-600 text-sm mb-2">{{ $m->descripcion }}</p>
                    
                    <!-- Precio normal -->
                    <p class="text-gray-500 text-sm line-through">
                        ${{ number_format($m->precio, 0, ',', '.') }}
                    </p>

                    <!-- Precio final con descuento -->
                    <p class="text-lg font-bold text-green-600">
                        ${{ number_format($m->precioConDescuento(), 0, ',', '.') }}
                    </p>
                </div>

                <!-- Promo activa -->
                @php
                    $promo = $m->promociones()
                        ->where('activo', true)
                        ->whereDate('fecha_inicio', '<=', now())
                        ->whereDate('fecha_fin', '>=', now())
                        ->first();
                @endphp

                @if($promo)
                    <div class="mt-3 text-sm text-blue-600">
                        🎉 {{ $promo->nombre }}: 
                        @if($promo->tipo_descuento === 'porcentaje')
                            -{{ $promo->valor_descuento }}%
                        @else
                            -${{ number_format($promo->valor_descuento, 0, ',', '.') }}
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-600">No se encontraron membresías.</p>
        @endforelse
    </div>
</div>
