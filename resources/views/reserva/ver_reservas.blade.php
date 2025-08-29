@extends('base')

@section('content')
    <h2>Listado de Reservas</h2>
    <x-table :columns="['ID', 'Persona', 'Zona', 'Fecha', 'Hora Desde', 'Hora Hasta']">
            @forelse($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->persona->nombre ?? 'N/A' }}</td>
                    <td>{{ $reserva->zona->descripcion ?? 'N/A' }}</td>
                    <td>{{ $reserva->fecha }}</td>
                    <td>{{ $reserva->hora_desde }}</td>
                    <td>{{ $reserva->hora_hasta }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay reservas disponibles.</td>
                </tr>
            @endforelse
    </x-table>
        

    <div class="d-flex justify-content-center">
        {{ $reservas->withQueryString()->links() }}
    </div>
@endsection
