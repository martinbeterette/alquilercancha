@extends('base')

@section('content')
<div class="container my-5">
    <a href="{{ route('sucursal.index') }}" class="btn btn-outline-secondary mb-4">
        ← Volver a sucursales
    </a>

    <h2 class="mb-3">{{ $sucursal->nombre }}</h2>
    <p class="text-muted">{{ $sucursal->direccion }}</p>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Canchas disponibles</h4>
        <a href="{{ route('zona.create', ['sucursal' => $sucursal->id]) }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i> Nueva cancha
        </a>
    </div>
    @if($sucursal->zonas && count($sucursal->zonas))
        <div class="row">
            @foreach ($sucursal->zonas as $zona)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-2-strong">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $zona->descripcion ?? 'Cancha #' . $zona->id }}</h5>
                                <p class="card-text">
                                    Tipo: {{ $zona->tipoZona->descripcion ?? 'N/D' }} <br>
                                    Superficie: {{ $zona->superficie->descripcion ?? 'N/D' }}
                                </p>
                            </div>
                            {{-- Si querés meter un botón de reservar, lo ponés acá --}}
                            <a href="/sucursales/reservar/{{ $zona->id }}" class="btn btn-primary mt-3">Reservar</a>
                            <div class="d-flex justify-content-between mt-3">
                                <a 
                                    href="{{ 
                                        route('zona.edit', 
                                            [
                                                'sucursal' => $sucursal->id, 
                                                "zona" => $zona->id,
                                            ]
                                        ) 
                                    }}" 
                                    class="btn btn-sm btn-outline-primary" 
                                    title="Editar"
                                >
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('zona.destroy', ["zona" => $zona->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro que querés eliminar esta cancha?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">No hay zonas registradas en esta sucursal todavía.</p>
    @endif
</div>
@endsection
