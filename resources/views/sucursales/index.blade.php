@extends('base') {{-- o el layout que uses --}}

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Nuestras Sucursales</h2>
            <a href="{{ route('sucursal.create') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Nueva sucursal
            </a>
        </div>
        
        <div class="row">
            @foreach ($sucursales as $sucursal)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-2-strong">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <h5 class="card-title">{{ $sucursal->nombre }}</h5>
                                <p class="card-text">{{ $sucursal->direccion }}</p>
                            </div>
                            <a href="{{ route('sucursal.show', ['sucursal' => $sucursal->id]) }}" class="btn btn-primary mt-3">Ver sucursal</a>
                            
                            <div class="d-flex justify-content-between mt-3">
                                <a 
                                    href="{{ route('sucursal.edit', ['sucursal' => $sucursal->id]) }}" 
                                    class="btn btn-sm btn-outline-primary" 
                                    title="Editar"
                                >
                                    <i class="fas fa-pen"></i>
                                </a>

                                <form action="{{ route('sucursal.destroy', ['sucursal' => $sucursal->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro que querés eliminar esta sucursal?');">
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
    </div>
@endsection
