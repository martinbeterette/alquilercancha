@extends('base')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Métodos de Pago</h2>
        <a href="{{ route('metodo_pago.create') }}" class="btn btn-primary">+ Crear Método</a>
    </div>

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('metodo_pago.index') }}" class="mb-3 d-flex" role="search">
        <input type="search" name="search" class="form-control me-2" 
               placeholder="Buscar por nombre..." 
               value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Buscar</button>
    </form>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($metodosPago as $metodo)
            <tr>
                <td>{{ $metodo->id }}</td>
                <td>{{ $metodo->nombre }}</td>
                <td>{{ $metodo->descripcion }}</td>
                <td>
                    <a href="{{ route('metodo_pago.edit', $metodo) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('metodo_pago.destroy', $metodo) }}" 
                          method="POST" 
                          style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Seguro querés eliminar este método de pago?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No se encontraron métodos de pago.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $metodosPago->withQueryString()->links() }}
    </div>
</div>
@endsection
