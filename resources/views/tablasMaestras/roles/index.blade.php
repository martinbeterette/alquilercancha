@extends('base')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Roles</h2>
        <a href="{{ route('roles.create') }}" class="btn btn-primary">+ Crear Rol</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $rol)
            <tr>
                <td>{{ $rol->id }}</td>
                <td>{{ $rol->name }}</td>
                <td>
                    <a href="{{ route('roles.edit', $rol) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('roles.destroy', $rol) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Seguro querés eliminar este rol?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
