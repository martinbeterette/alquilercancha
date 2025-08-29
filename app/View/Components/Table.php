<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;


/**
 * Componente de tabla reutilizable.
 *
 * Acepta un array de columnas y un valor opcional de colspan para manejar diferentes botones de acciones.
 * Ejemplo de uso:
 * <x-table :columns="['ID', 'Email']" :colspan="1">
 *     @foreach($users as $user)
 *         <tr>
 *             <td>{{ $user->email }}</td>
 *            <td><a href="#">Editar</a></td>
 *         </tr>
 *     @endforeach
 * </x-table>
 *
 * Si no se proporcionan columnas, se mostrará un mensaje indicando que no hay datos disponibles.
 */
class Table extends Component
{
    public $columns;
    public $colspan;

    /**
     * Create a new component instance.
     */
    public function __construct($columns = [], $colspan = null)
    {
        $this->columns = $columns;
        $this->colspan = $colspan;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.table');
    }
}
