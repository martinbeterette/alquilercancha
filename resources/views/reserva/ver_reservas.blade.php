@extends('base')

@section('content')
    <h2>Listado de Reservas</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Persona</th>
                <th>Cancha</th>
                <th>Fecha</th>
                <th>Hora Desde</th>
                <th>Hora Hasta</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->persona->nombre ?? 'N/A' }}</td>
                    <td>{{ $reserva->zona->descripcion ?? 'N/A' }}</td>
                    <td>{{ $reserva->fecha }}</td>
                    <td>{{ $reserva->hora_desde }}</td>
                    <td>{{ $reserva->hora_hasta }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $reservas->withQueryString()->links() }}
    </div>
@endsection
