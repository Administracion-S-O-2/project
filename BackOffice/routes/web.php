<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComprobanteController;
use App\Http\Controllers\NoAprobadoController;
use App\Http\Controllers\UnidadHabitacionalController;
use App\Http\Controllers\EtapaController;
use App\Http\Controllers\AsambleaController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\ValidarId;

Route::middleware('auth:admin')->group(function () {
    Route::get('/noAprobados',[NoAprobadoController::class, "Index"] )->name('solicitudes');
    Route::get('/noAprobado/approve/{id}', [NoAprobadoController::class, "approve"]);
    Route::get('/noAprobado/refuse/{id}', [NoAprobadoController::class, "refuse"]);

    Route::get('/users', [UserController::class, "Index"])->name('users');
    Route::put('/user/assigne', [UserController::class, "assigne"])->name('user.assigne');
    
    Route::get('/user/{id}/workHours', [UserController::class, "workHours"]);
    Route::get('/user/{id}/comprobantes', [UserController::class, "comprobantes"]);

    Route::get('/unidades', [UnidadHabitacionalController::class, "Index"])->name('unidades');
    Route::get('/unidad/create', [UnidadHabitacionalController::class, "create"])->name('unidad.create.view');
    Route::post('/unidad', [UnidadHabitacionalController::class, "store"])->name('unidad.create');
    Route::get('/unidad/assigne/{id}', [UnidadHabitacionalController::class, "assigne"]);
    Route::get('/unidad/detail/{id}', [UnidadHabitacionalController::class, "detail"]);
    Route::put('/unidad/update', [UnidadHabitacionalController::class, "update"])->name('unidad.update');

    Route::get('/etapa/create', [EtapaController::class, "create"])->name('etapa.create.view');
    Route::post('/etapa', [EtapaController::class, "store"])->name('etapa.create');

    Route::get('/asambleas', [AsambleaController::class, "index"])->name('asambleas');
    Route::post('/asamblea', [AsambleaController::class, "create"])->name('asamblea.create');
    Route::view('/asamblea/create', 'asamblea.create')->name("asamblea.create.view");
    Route::get('/asamblea/{id}', [AsambleaController::class, "detail"]);

    Route::get('/pendingComprobantes', [ComprobanteController::class, "pendingComprobantes"])->name('pending.comprobantes');
    Route::get('/comprobante/approve/{id}', [ComprobanteController::class, "approve"]);
    Route::get('/comprobante/refuse/{id}', [ComprobanteController::class, "refuse"]);

    Route::get('/admin/profile',[AdminController::class, "profile"] )->name('admin.profile');
    Route::get('/admin/comprobantes',[AdminController::class, "comprobantes"] )->name('admin.comprobantes');
    Route::get('/admin/solicitudes',[AdminController::class, "solicitudes"] )->name('admin.solicitudes');
    Route::post('/admin',[AdminController::class, "store"] )->name('admin.store');
    Route::get('/admin',[AdminController::class, "create"] )->name('admin.create');
});

Route::redirect('/', '/home');
Route::view('/home', 'home')->name("home");
Route::view('/login', 'login')->name('login.view');
Route::post('/login', [AdminLoginController::class, 'login'])->name('login');
Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

