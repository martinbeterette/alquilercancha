<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\EstadoZonaController;
use App\Http\Controllers\TipoContactoController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\TipoZonaController;
use App\Http\Controllers\EstadoReservaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DeporteController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\SuperficieController;
use App\Http\Controllers\TipoDeporteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/personas',             [PersonaController::class, 'indexApi']);
Route::post('/personas',            [PersonaController::class, 'store']);
Route::get('/personas/{id}',        [PersonaController::class, 'show']);
Route::put('/personas/{id}',        [PersonaController::class, 'update']);
Route::delete('/personas/{id}',     [PersonaController::class, 'destroy']);

Route::get('tipo-contacto',        [TipoContactoController::class, 'indexApi']);
Route::post('tipo-contacto',       [TipoContactoController::class, 'store']);

Route::get('tipo-documento',       [TipoDocumentoController::class, 'indexApi']);
Route::post('tipo-documento',      [TipoDocumentoController::class, 'store']);

Route::get('contactos',             [ContactoController::class, 'index']);
Route::post('contactos',            [ContactoController::class, 'store']);

Route::get('rol',                   [RolController::class, 'indexApi']);
Route::post('rol',                  [RolController::class, 'store']);

Route::get('usuarios',              [UsuarioController::class, 'index']);
Route::post('usuarios',             [UsuarioController::class, 'store']);

Route::get('deportes',              [DeporteController::class, 'indexApi']);
Route::get('deportes+trash',        [DeporteController::class, 'index']);
Route::post('deportes',             [DeporteController::class, 'store']);

Route::get('tipo-deporte',          [TipoDeporteController::class, 'indexApi']);

Route::get('sexos',                 [SexoController::class, 'indexApi']);
Route::post('sexos',                [SexoController::class, 'store']);

Route::get('superficie',            [SuperficieController::class, 'indexApi']);

Route::get('tipo-zona',             [TipoZonaController::class, 'indexApi']);

Route::get('estado-reserva',             [EstadoReservaController::class, 'indexApi']);

Route::get('estado-zona',             [EstadoZonaController::class, 'indexApi']);
