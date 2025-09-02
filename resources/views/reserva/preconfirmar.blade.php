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
        @method('POST')

        {{-- Campos ocultos para enviar los datos necesarios --}}       
        <input type="hidden" name="fecha" value="{{ $request->fecha }}">
        <input type="hidden" name="hora_desde" value="{{ $desde->format('H:i:s') }}">
        <input type="hidden" name="hora_hasta" value="{{ $hasta->format('H:i:s') }}">

        {{-- Botones de acción --}}

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success flex-grow-1">Confirmar Reserva</button>
            <a href="{{ route('seleccionar.horario', ["persona" => $persona, "cancha" => $cancha]) }}" class="btn btn-outline-secondary flex-grow-1">Cancelar</a>
        </div>
    </form>

</div>
@endsection