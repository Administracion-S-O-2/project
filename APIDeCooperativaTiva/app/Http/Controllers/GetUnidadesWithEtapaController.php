<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UnidadHabitacional;
use App\Models\Etapa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class GetUnidadesWithEtapaController extends Controller
{
    public function getUnidadesWithEtapa(){
        try {
            $unidades = UnidadHabitacional::with('etapa')->get();
            return response()->json([$unidades], 200);
        } catch (Exception $ex){
            Log::error("Ocurrion error en getUnidadesWithEtapa " . $ex->getMessage());
            return response()->json([
                'error' => 'Error inesperado en el servidor'
            ], 500);
        }
    }
}
