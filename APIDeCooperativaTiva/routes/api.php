<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkHoursController;
use App\Http\Middleware\Autenticacion;
use App\Http\Controllers\ComprobanteController;
use App\Http\Controllers\GetUnidadesWithEtapaController;

Route::middleware([Autenticacion::class])->group(function () {

    Route::get('/work-hours', [WorkHoursController::class, 'index']);
    Route::post('/work-hours', [WorkHoursController::class, 'store']);
    Route::get('/comprobantes', [ComprobanteController::class, 'getComprobantesFromUser']);
    Route::get('/datos', function () {
        return response()->json(['mensaje' => 'Token válido']);
    });

    Route::get('/usuario', function (Request $request) {
        return $request->user();
    });

    Route::post('/comprobante', [ComprobanteController::class, 'store']);
    Route::get('/comprobantes/pending', [ComprobanteController::class, 'pending']);

    Route::get('/unidades', [GetUnidadesWithEtapaController::class, 'getUnidadesWithEtapa']);
});