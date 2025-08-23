@extends('base')

@section('content')
<div class="container my-4">
    <h2>Crear Usuario</h2>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        {{-- BLOQUE: Datos de Usuario --}}
        <h4>Datos de Usuario</h4>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre de Usuario</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
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

        {{-- BLOQUE: Datos Personales --}}
        <h4>Datos Personales</h4>
        <div class="mb-3">
            <label for="persona_nombre" class="form-label">Nombre</label>
            <input type="text" name="persona_nombre" id="persona_nombre" class="form-control" value="{{ old('persona_nombre') }}">
        </div>

        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" name="apellido" id="apellido" class="form-control" value="{{ old('apellido') }}">
        </div>

        <div class="mb-3">
            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
            <select name="tipo_documento" id="tipo_documento" class="form-select">
                @foreach($tipos_documento as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="documento" class="form-label">Número de Documento</label>
            <input type="text" name="documento" id="documento" class="form-control" value="{{ old('documento') }}">
        </div>

        <div class="mb-3">
            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
        </div>

        <div class="mb-3">
            <label for="sexo" class="form-label">Sexo</label>
            <select name="sexo" id="sexo" class="form-select">
                @foreach($sexos as $sexo)
                    <option value="{{ $sexo->id }}">{{ $sexo->descripcion }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Crear Usuario</button>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
