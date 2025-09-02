@extends('base')

@section('title', 'Confirmar Reserva')

@section('content')
<div class="container mt-4">

    <x-comprobante-reserva 
        :persona="$persona" 
        :cancha="$cancha" 
        :sucursal="$sucursal" 
        :fecha="$fecha" 
        :fecha-hora-desde="$desde" 
        :fecha-hora-hasta="$hasta" 
    />

    <form action="{{ route('crear.reserva', ['persona' => $persona->id, 'cancha' => $cancha->id]) }}" method="POST" class="mt-3" id="form-confirmacion">
        @csrf
        <input type="hidden" name="fecha" value="{{ $request->fecha }}">
        <input type="hidden" name="hora_desde" value="{{ $desde }}">
        <input type="hidden" name="hora_hasta" value="{{ $hasta }}">

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success flex-grow-1">Confirmar Reserva</button>
            <a href="{{ route('reserva_interna') }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
        </div>
    </form>

</div>
@endsection