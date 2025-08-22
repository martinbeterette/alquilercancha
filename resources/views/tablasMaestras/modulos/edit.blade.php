@extends('base')

@section('content')
<div class="container my-4">
    <h2>Editar Módulo</h2>

    <form action="{{ route('modulos.update', $modulo) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $modulo->name) }}" >
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $modulo->slug) }}" >
        </div>

        {{-- Icon --}}
        <div class="mb-3">
            <label for="icon" class="form-label">Icono</label>
            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $modulo->icon) }}">
        </div>

        {{-- Roles --}}
        <div class="mb-3">
            <label class="form-label">Roles asignados</label>
            <div class="d-flex flex-wrap">
                @foreach($roles as $role)
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                            id="role{{ $role->id }}"
                            {{ $modulo->roles->contains($role->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('modulos.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection