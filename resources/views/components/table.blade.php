{{--
    Componente: Table

    Atributos:
    - columns (array): Array de strings con los nombres de las columnas del encabezado.
    - colspan (int|null): Cantidad de columnas para la celda "Acciones" al final del encabezado. Opcional, por defecto null. Si no se pasa, no se renderiza.

    Uso:

    <x-tabla :columns="['Nombre', 'Apellido']" :colspan="2">
        @forelse($personas as $persona)
            <tr>
                <td>{{ $persona->nombre }}</td>
                <td>{{ $persona->apellido }}</td>
                <td>Botón 1</td>
                <td>Botón 2</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay personas</td>
            </tr>
        @endforelse
    </x-tabla>

    Notas:
    - $columns se pasa con ":" para que se interprete como PHP, no como string literal.
    - El contenido de <tbody> se pasa usando el slot del componente.
    - colspan es opcional y controla la celda de "Acciones" al final del encabezado.
--}}
<table class="table table-striped w-full border-collapse border">
    <thead>
        <tr>
            @foreach($columns as $column)
                <th class="border px-4 py-2 text-left">{{ $column }}</th>
            @endforeach

            @if ($colspan)
                <th class="border px-4 py-2 text-center" colspan="{{ $colspan }}">Acciones</th>   
            @endif
        </tr>
    </thead>
    <tbody>
        {{ $slot }}
    </tbody>
</table>