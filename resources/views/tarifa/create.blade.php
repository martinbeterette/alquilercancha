@extends('base')
@section('title', 'Crear Tarifa')

@section('content')
<div class="container my-4">
    <h2>Crear Tarifa</h2>

    <form action="{{ route('sucursal.tarifa.store', ["sucursal" => $sucursal]) }}" method="POST">
        @csrf
        @method('POST')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}">
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" name="precio" id="precio" class="form-control" value="{{ old('precio') }}">
        </div>

        <div class="mb-3">
            <label for="hora-desde" class="form-label">Hora desde</label>
            <input type="time" name="hora-desde" id="hora-desde" class="form-control" value="{{ old('hora-desde') }}">
        </div>

        <div class="mb-3">
            <label for="hora-hasta" class="form-label">Hora hasta</label>
            <input type="time" name="hora-hasta" id="hora-hasta" class="form-control" value="{{ old('hora-hasta') }}">
        </div>

        <button type="submit" class="btn btn-success">Crear Tarifa</button>
        <a href="{{ route('sucursal.tarifa.index', ["sucursal" => $sucursal]) }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection

