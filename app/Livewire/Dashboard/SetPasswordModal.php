<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SetPasswordModal extends Component
{
    public $password;
    public $password_confirmation;

    public function save()
    {
        $this->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($this->password);
        $user->save();

        // Guardamos mensaje en sesión para mostrar toast
        session()->flash('toast_success', 'Contraseña establecida correctamente.');

        // Redirigimos para que se refresque el dashboard y muestre el toast
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.dashboard.set-password-modal');
    }
}
