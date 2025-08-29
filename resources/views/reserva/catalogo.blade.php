@extends('base')

@section('title', 'Catálogo de Reservas')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Gestión de Reservas</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Card Ver Reservas --}}
            <a href="{{ route('ver.reservas') }}"
                class="block p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">📋 Ver Reservas</h2>
                <p class="text-gray-500">Consulta todas las reservas realizadas en el sistema.</p>
            </a>

            {{-- Card Realizar Reserva --}}
            <a href="{{ route('reserva_interna') }}"
                class="block p-6 bg-white rounded-2xl shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-700 mb-2">📝 Realizar una Reserva</h2>
                <p class="text-gray-500">Crea una nueva reserva para una persona y cancha.</p>
            </a>

        </div>
    </div>
@endsection