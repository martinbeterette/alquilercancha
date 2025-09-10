@extends('base')
@section('title', 'Listado de Tarifas')
@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Listado de Tarifas</h2>
        <a href="{{ route('sucursal.tarifa.create', $sucursal) }}" class="btn btn-primary">+ Crear Tarifa</a>
    </div>

    <x-table
        :columns="['Nombre', 'Precio', 'Hora Desde', 'Hora Hasta', 'Sucursal']"
        colspan="2"
    >
    @forelse ($tarifas as $tarifa)
        <tr>
            <td>{{$tarifa->nombre}}</td>
            <td>{{$tarifa->precio}}</td>
            <td>{{$tarifa->hora_desde}}</td>
            <td>{{$tarifa->hora_hasta}}</td>
            <td>{{$sucursal->nombre}}</td>
            <td class="text-center">
                <x-button.edit :route="route('sucursal.tarifa.edit', [$sucursal, $tarifa])" />
                <x-button.delete :route="route('sucursal.tarifa.destroy', [$sucursal, $tarifa])" />
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No hay tarifas disponibles.</td>
        </tr>
    @endforelse
    </x-table>
    
</div>
@endsection
