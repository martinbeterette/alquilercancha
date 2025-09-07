<?php

use App\Livewire\EmpleadoCargo\Index;
use Illuminate\Support\Facades\Route;
use App\Livewire\Empleados\EmpleadoIndex;

require __DIR__.'/routes_breeze.php';
require __DIR__.'/routes.php';

Route::middleware(['auth', 'verified', 'has_module:Empleados'])->group(function () {
    Route::get('/empleado', EmpleadoIndex::class)
        ->name('empleado.index');

    Route::get('/empleado-cargo', Index::class)->name('empleado_cargo.index');
});
