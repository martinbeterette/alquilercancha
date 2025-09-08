<?php

namespace App\Livewire\Membresias;

use Livewire\Component;
use App\Models\Complejo;
use App\Models\Membresia;

class Index extends Component
{
    public $complejo;
    public $search = '';

    public function mount(Complejo $complejo)
    {
        $this->complejo = $complejo;
    }

    public function render()
    {
        $membresias = Membresia::where('complejo_id', $this->complejo->id)
            ->when($this->search, fn($q) => 
                $q->where('nombre', 'like', "%{$this->search}%")
            )
            ->with('promociones')
            ->get();

        return view('livewire.membresias.index', [
            'membresias' => $membresias,
            'complejo' => $this->complejo,
        ]);
    }
}
