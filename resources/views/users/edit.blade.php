@extends('base')

@section('content')
<div class="container my-4">
    <h2>Editar Usuario</h2>

    <form action="{{ route('usuarios.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        {{-- Roles --}}
        <div class="mb-3">
            <label class="form-label">Roles</label>
            <div class="d-flex flex-wrap">
                @foreach($roles as $role)
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}"
                            id="role{{ $role->id }}"
                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="role{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
