{{-- resources/views/components/button/delete.blade.php --}}
@props(['route', 'confirm' => '¿Estás seguro de que deseas eliminar este registro?'])

<form action="{{ $route }}" method="POST" onsubmit="return confirm('{{ $confirm }}');" class="d-inline">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
</form>