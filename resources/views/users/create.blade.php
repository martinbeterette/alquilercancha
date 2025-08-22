@extends('base')

@section('content')
<div class="container my-4">
    <h2>Crear Usuario</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" >
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" >
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" >
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" >
        </div>

        {{-- Roles --}}
        <div class="mb-3">
            <label class="form-label">Roles asignados</label>
            <div class="d-flex flex-wrap">
                @foreach($roles as $role)
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role{{ $role->id }}">
                        <label class="form-check-label" for="role{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Crear Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection