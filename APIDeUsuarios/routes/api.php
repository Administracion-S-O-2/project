<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NoAprobadoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/user',[UserController::class,"Register"]);
Route::post('/noAprobado',[NoAprobadoController::class,"create"]);
Route::get('/validate',[UserController::class,"ValidateToken"])->middleware('auth:api');
Route::get('/logout',[UserController::class,"Logout"])->middleware('auth:api');
Route::post('/editar', [UserController::class, 'Editar']);
Route::middleware('auth:api')->get('/usuario/{id}', [UserController::class, 'BuscarParaEditar']);
Route::post('/cambiarpassword', [UserController::class, 'CambiarPassword']);

