@extends('base')

@section('content')
<div class="container my-4">
    <h2>Crear Rol</h2>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf

        {{-- Nombre --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Crear Rol</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
