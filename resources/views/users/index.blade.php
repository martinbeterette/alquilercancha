@extends('base')
@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Usuarios</h2>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">+ Crear Usuario</a>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @foreach($user->roles as $role)
                        <span class="badge bg-success">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-warning">Editar</a>

                    <form action="{{ route('usuarios.destroy', $user) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Seguro querés eliminar este usuario?')">
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
