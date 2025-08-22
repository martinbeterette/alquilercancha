@extends('base')

@section('content')
<div class="container my-4">
    <h2>Editar Rol</h2>

    <form action="{{ route('roles.update', $rol) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $rol->name) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
