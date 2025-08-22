@extends('base')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Módulos</h2>
        <a href="{{ route('modulos.create') }}" class="btn btn-primary">+ Agregar Módulo</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Slug</th>
                <th>Icono</th>
                <th>Roles Asignados</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modulos as $modulo)
            <tr>
                <td>{{ $modulo->id }}</td>
                <td>{{ $modulo->name }}</td>
                <td>{{ $modulo->slug }}</td>
                <td>{{ $modulo->icon }}</td>
                <td>
                    @foreach($modulo->roles as $role)
                        <span class="badge bg-success">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('modulos.edit', $modulo) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('modulos.destroy', $modulo) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Seguro querés eliminar este módulo?')">
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