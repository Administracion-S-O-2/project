<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use App\Models\Comprobante;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use App\Models\WorkHours;

class UserController 
{
    
    public function Index(){
        try {
            $users = User::with('UnidadHabitacional')->get();
            return view("user.index", ["users" => $users]);
        } catch (Exception $ex){
            Log::error("Error al cargar listado de socios " . $ex->getMessage());
            return redirect()->route('home')->with("error" , $ex->getMessage());
        }

    }

    public function assigne(Request $request){
        try {
            $user = User::findOrFail($request->input("user_id"));
            $user->assigne($request->input("unidad_id"));
            return redirect()->route("users")->with("success", "Unidad asignada exitosamente");
        } catch (ModelNotFoundException $ex) {
            Log::warning("Id de User no encontrado en asignacion de unidad h. " . $ex->getMessage());
            return redirect()->route("unidad.create.view")->with("error", $ex->getMessage());
        } catch (Exception $ex){
            Log::error("Error al asignar un socio a una unidad habitacional " . $ex->getMessage());
            return redirect('/unidad/assigne/$request->input("unidad_id")')->with("error", $ex->getMessage());
        }
    }

    public function workHours($id){
          try {
            $user = User::find($id);
            $hours = $user->WorkHours;
            return view('user.recordOfWorkedHours', ["hours" => $hours]);
        } catch (Exception $ex){
            Log::error('Ocurrio un error al mostrar historial de comprobantes de user ' . $ex->getMessage());
            return redirect()->back();
        }
    }

    public function comprobantes($id){
        try {
            $user = User::find($id);
            $comprobantes = $user->Comprobantes;
            return view('user.recordOfComprobantes', ["comprobantes" => $comprobantes]);
        } catch (Exception $ex){
            Log::error('Ocurrio un error al mostrar historial de comprobantes de user ' . $ex->getMessage());
            return redirect()->back();
        }
    }
}
