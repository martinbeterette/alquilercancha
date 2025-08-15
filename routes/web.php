<?php
use Illuminate\Support\Facades\Route;

require __DIR__.'/routes_breeze.php';
require __DIR__.'/routes.php';

Route::get('solo-loquitos', function () {
    return "Solo Loquitos";
})->middleware(['auth', 'role:admin']);