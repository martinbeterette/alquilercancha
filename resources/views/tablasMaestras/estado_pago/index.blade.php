@extends('base')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Estados de Pago</h2>
        <a href="{{ route('estado_pago.create') }}" class="btn btn-primary">+ Crear Estado</a>
    </div>

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('estado_pago.index') }}" class="mb-3 d-flex" role="search">
        <input type="search" name="search" class="form-control me-2" 
               placeholder="Buscar por nombre..." 
               value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Buscar</button>
    </form>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($estadosPago as $estado)
            <tr>
                <td>{{ $estado->id }}</td>
                <td>{{ $estado->descripcion }}</td>
                <td>
                    <a href="{{ route('estado_pago.edit', $estado) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('estado_pago.destroy', $estado) }}" 
                          method="POST" 
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Seguro querés eliminar este estado de pago?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No se encontraron estados de pago.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $estadosPago->withQueryString()->links() }}
    </div>
</div>
@endsection
