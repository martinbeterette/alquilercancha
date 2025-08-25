<?php
use Illuminate\Support\Facades\Route;

require __DIR__.'/routes_breeze.php';
require __DIR__.'/routes.php';

Route::get('solo-loquitos', function () {
    return "Solo Loquitos";
})->middleware(['has_module:asndiaubibdowa']);

Route::prefix('tablas-maestras')->group(function () {
    //todas las 800 rutas (broma)
})->middleware(['auth', 'has_role:Tablas Maestras']);