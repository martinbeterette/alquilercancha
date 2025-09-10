@extends('base')
@section('title', 'Editar Tarifa')

@section('content')
<div class="container my-4">
    <h2>Crear Tarifa</h2>

    <form action="{{ route('sucursal.tarifa.update', [$sucursal, $tarifa]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $tarifa) }}">
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" name="precio" id="precio" class="form-control" value="{{ old('precio', $tarifa) }}">
        </div>

        <div class="mb-3">
            <label for="hora-desde" class="form-label">Hora desde</label>
            <input type="time" name="hora-desde" id="hora-desde" class="form-control" value="{{ old('hora-desde', $tarifa->hora_desde) }}">
        </div>

        <div class="mb-3">
            <label for="hora-hasta" class="form-label">Hora hasta</label>
            <input type="time" name="hora-hasta" id="hora-hasta" class="form-control" value="{{ old('hora-hasta', $tarifa->hora_hasta) }}">
        </div>

        <button type="submit" class="btn btn-success">Actualizar Tarifa</button>
        <a href="{{ route('sucursal.tarifa.index', ["sucursal" => $sucursal]) }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection

