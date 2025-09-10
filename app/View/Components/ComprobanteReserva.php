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
    public $desde;
    public $hasta;
    public $tarifaAplicada;
    /**
     * Create a new component instance.
     */
    public function __construct($persona, $cancha, $sucursal, $fecha, $fechaHoraDesde, $fechaHoraHasta, $tarifaAplicada)
    {
        $this->persona = $persona;
        $this->cancha = $cancha;
        $this->sucursal = $sucursal;
        $this->fecha = $fecha;
        $this->desde = $fechaHoraDesde;
        $this->hasta = $fechaHoraHasta;
        $this->tarifaAplicada = $tarifaAplicada;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comprobante-reserva');
    }
}
