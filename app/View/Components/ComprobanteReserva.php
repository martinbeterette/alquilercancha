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
    public $horaDesde;
    public $horaHasta;
    /**
     * Create a new component instance.
     */
    public function __construct($persona, $cancha, $sucursal, $fecha, $horaDesde, $horaHasta)
    {
        $this->persona = $persona;
        $this->cancha = $cancha;
        $this->sucursal = $sucursal;
        $this->fecha = $fecha;
        $this->horaDesde = $horaDesde;
        $this->horaHasta = $horaHasta;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comprobante-reserva');
    }
}
