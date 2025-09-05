<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\PerfilController as RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\TarifaController;

// PARA LA EXPO DEL MARTES
Route::get('admin', fn() => view('admin.administracion'))
    ->name('admin.config')
    ->middleware(['auth', 'has_module:Administración']);

Route::get('/', [HomeController::class, 'home'])
    ->middleware(['auth', 'verified']);

Route::get('/home', [HomeController::class, 'home'])
    ->middleware(['auth', 'verified']);

Route::resource('/sucursal', SucursalController::class)
    ->names('sucursal')
    ->middleware(['auth', 'verified', 'has_module:sucursales']);

Route::resource('roles', RolesController::class)
    ->names('roles')
    ->parameter('roles', 'rol')
    ->middleware(['auth','verified','has_module:Administración']);

Route::resource('modulos', ModuloController::class)
    ->names('modulos')
    ->parameter('modulos', 'modulo')
    ->middleware(['auth','verified','has_module:Administración']);

Route::resource('/usuarios', UserController::class)
    ->names('usuarios')
    ->parameters(['usuarios' => 'user'])
    ->middleware(['auth','verified','has_module:Administración']);


//ZONAS 
Route::resource('/zona', ZonaController::class)->names('zona');

Route::resource('sucursal.tarifa', TarifaController::class)
    ->names('sucursal.tarifa')
    ->parameters(['sucursal' => 'sucursal', 'tarifa' => 'tarifa'])
    ->middleware(['auth','verified','has_module:sucursales']);


//reservas
Route::middleware(['auth','verified','has_module:reservas'])->group(function () {

    Route::get('reservas', fn() => view('reserva.catalogo'))                                                                            ->name('reservas.catalogo');
    Route::get('reserva-interna', fn() => view('reserva.interna'))                                                                      ->name('reserva_interna');
    Route::post('crear-cliente-nuevo', [ReservaController::class, 'crearClienteNuevo'])                                                 ->name('cliente_nuevo.create');
    Route::get('reserva-interna/persona/{persona}/cancha', [ReservaController::class, 'seleccionarHoraYCancha'])                        ->name('seleccionar.hora.y.cancha');
    Route::get('reserva-interna/persona/{persona}/cancha/{cancha}/horario', [ReservaController::class, 'seleccionarHorario'])           ->name('seleccionar.horario');
    Route::get('reserva-interna/persona/{persona}/cancha/{cancha}/horario/preconfirmar', [ReservaController::class, 'preconfirmar'])   ->name('preconfirmar.reserva');
    Route::post('reserva-interna/persona/{persona}/cancha/{cancha}/horario', [ReservaController::class, 'store'])                       ->name('crear.reserva');
    Route::get('ver-reservas', [ReservaController::class, 'verReservas'])                                                               ->name('ver.reservas');
});

Route::get('/test/disponibilidad-horaria', [ReservaController::class, 'testDisponibilidadHoraria']);
Route::get('/test/preconfirmacion', [ReservaController::class, 'testPreConfirmacion']);
Route::get('/test/tarifa-pisada', [TarifaController::class, 'testTarifaPisada']);






require __DIR__.'/tablas_maestras.php';











