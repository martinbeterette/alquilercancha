<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ComprobanteReserva extends Component
{   
    public $persona;
    public $cancha;
    public $sucursal;
    public $fecha;
    public $hora_desde;
    public $hora_hasta;
    /**
     * Create a new component instance.
     */
    public function __construct($persona, $cancha, $sucursal, $fecha, $hora_desde, $hora_hasta)
    {
        $this->persona = $persona;
        $this->cancha = $cancha;
        $this->sucursal = $sucursal;
        $this->fecha = $fecha;
        $this->hora_desde = $hora_desde;
        $this->hora_hasta = $hora_hasta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comprobante-reserva');
    }
}
