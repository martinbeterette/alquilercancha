<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\EstadoZonaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\DeporteController;
use App\Http\Controllers\SexoController;
use App\Http\Controllers\SuperficieController;
use App\Http\Controllers\TipoContactoController;
use App\Http\Controllers\TipoDocumentoController;
use App\Http\Controllers\TipoZonaController;
use App\Http\Controllers\EstadoReservaController;
use App\Http\Controllers\TipoDeporteController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\LocalidadController;
use App\Http\Controllers\ReservaController;



Route::get('/', [HomeController::class, 'home']);


/*Route::prefix('/personas')->group(function () {
    
});*/

Route::get('/personas', [PersonaController::class, 'index']);

// LOGIN
Route::get('/login-casero',    [AuthController::class, 'showLoginForm'])->name('login.casero');
Route::post('/login-casero',   [AuthController::class, 'login']);
Route::get('/cerrar-sesion', [AuthController::class, 'logout'])->name('logout.casero');

// REGISTRO USUARIO
Route::get('/formulario-registro', [AuthController::class, 'showRegisterForm'])->name('formularioRegistro');
Route::post('/registrar-usuario', [AuthController::class, 'recibirFormularioRegistro'])->name('procesarRegistro');

// INICIO
//prueba
Route::get('/home', [HomeController::class, 'home']);

// SUCURSALES
Route::resource('/sucursal', SucursalController::class)->names('sucursal');

//ZONAS 
Route::resource('/zona', ZonaController::class)->names('zona');

Route::prefix('tablas-maestras')->group(function () {
    //CATALOGO
    Route::get('/', fn() => view('tablasMaestras/tablasMaestras'))->name('tablas_maestras.index');

    // ROL
    Route::get('/rol', fn() => view('tablasMaestras/rol/index'))->name('rol.index');
    Route::get('/rol/crear', [RolController::class, 'create'])->name('rol.create');
    Route::post('/rol/crear/insert', [RolController::class, 'store'])->name('rol.insert');
    Route::get('/rol/modificar/{id}/edit', [RolController::class, 'edit'])->name('rol.edit');
    Route::put('/rol/modificar/{id}', [RolController::class, 'update'])->name('rol.update');
    Route::delete('/rol/eliminar/{id}', [RolController::class, 'destroy'])->name('rol.delete');

    // DEPORTE
    Route::get('/deporte', fn() => view('tablasMaestras/deporte/index'))->name('deporte.index');
    Route::get('/deporte/crear', [DeporteController::class, 'create'])->name('deporte.create');
    Route::post('/deporte/crear/insert', [DeporteController::class, 'store'])->name('deporte.insert');
    Route::get('/deporte/modificar/{id}/edit', [DeporteController::class, 'edit'])->name('deporte.edit');
    Route::put('/deporte/modificar/{id}', [DeporteController::class, 'update'])->name('deporte.update');
    Route::delete('/deporte/eliminar/{id}', [DeporteController::class, 'destroy'])->name('deporte.delete');

    // SEXO
    Route::get('/sexo', fn() => view('tablasMaestras/sexo/index'))->name('sexo.index');
    Route::get('/sexo/crear', [SexoController::class, 'create'])->name('sexo.create');
    Route::post('/sexo/crear/insert', [SexoController::class, 'store'])->name('sexo.insert');
    Route::get('/sexo/modificar/{id}/edit', [SexoController::class, 'edit'])->name('sexo.edit');
    Route::put('/sexo/modificar/{id}', [SexoController::class, 'update'])->name('sexo.update');
    Route::delete('/sexo/eliminar/{id}', [SexoController::class, 'destroy'])->name('sexo.delete');

    // ESTADO ZONA
    Route::get('/estado-zona', fn() => view('tablasMaestras/estadoZona/index'))->name('estado_zona.index');
    Route::get('/estado-zona/crear', [EstadoZonaController::class, 'create'])->name('estado_zona.create');
    Route::post('/estado-zona/crear/insert', [EstadoZonaController::class, 'store'])->name('estado_zona.insert');
    Route::get('/estado-zona/modificar/{id}/edit', [EstadoZonaController::class, 'edit'])->name('estado_zona.edit');
    Route::put('/estado-zona/modificar/{id}', [EstadoZonaController::class, 'update'])->name('estado_zona.update');
    Route::delete('/estado-zona/eliminar/{id}', [EstadoZonaController::class, 'destroy'])->name('estado_zona.delete');

    // SUPERFICIE
    Route::get('/superficie', fn() => view('tablasMaestras/superficie/index'))->name('superficie.index');
    Route::get('/superficie/crear', [SuperficieController::class, 'create'])->name('superficie.create');
    Route::post('/superficie/crear/insert', [SuperficieController::class, 'store'])->name('superficie.insert');
    Route::get('/superficie/modificar/{id}/edit', [SuperficieController::class, 'edit'])->name('superficie.edit');
    Route::put('/superficie/modificar/{id}', [SuperficieController::class, 'update'])->name('superficie.update');
    Route::delete('/superficie/eliminar/{id}', [SuperficieController::class, 'destroy'])->name('superficie.delete');

    //TIPO_CONTACTO
    Route::resource('tipo-contacto', TipoContactoController::class)->names('tipo_contacto')->except(['show']);

    //TIPO_DOCUMENTO
    Route::resource('tipo-documento', TipoDocumentoController::class)->names('tipo_documento')->except(['show']);

    //TIPO_ZONA
    Route::resource('tipo-zona', TipoZonaController::class)->names('tipo_zona')->except(['show']);

    //ESTADO RESERVA
    Route::resource('estado-reserva', EstadoReservaController::class)->names('estado_reserva')->except(['show']);

    //TIPO DEPORTE
    Route::resource('tipo-deporte', TipoDeporteController::class)->names('tipo_deporte')->except(['show']);

    //PROVINCIA
    Route::resource('provincia', ProvinciaController::class)->names('provincia')->except(['show'])->parameters(['provincia' => 'provincia']);

    //LOCALIDAD
    Route::resource('localidad', LocalidadController::class)->names('localidad')->except(['show'])->parameters(['localidad' => 'localidad']);

    Route::resource('barrio', BarrioController::class)->names('barrio')->except(['show'])->parameters(['barrio' => 'barrio']);

});

//mi perfil
Route::get('/mi-perfil', [UsuarioController::class, 'mostrarMiPerfil'])->name('miPerfil');
Route::get('/perfil/cambiar-contraseña', fn() => view('auth_casero.cambiarContrasena'))->name('actualizarContrasena');
Route::post('/perfil/cambiar-contraseña', [UsuarioController::class, 'cambiarContrasena'])->name('cambiarContrasena');


Route::get('reserva-interna', fn() => view('reserva.interna'))->name('reserva_interna');
Route::post('crear-cliente-nuevo', [ReservaController::class, 'crearClienteNuevo'])->name('cliente_nuevo.create');
Route::get('reserva-interna/{persona}', [ReservaController::class, 'seleccionarHoraYCancha'])->name('seleccionar.hora.y.cancha');



















//PROTOTIPO PRIMER INICIO DEL ADMINISTRADOR
Route::get('/primer-inicio', function() {
    return view('basura.primerInicio');
});

// PRUEBA
Route::get('/sublime-merge', function() {
    return view("basura.sublimeMerge");
});

Route::get('/prueba', function() {
    return view("basura.probando_funciones");
});