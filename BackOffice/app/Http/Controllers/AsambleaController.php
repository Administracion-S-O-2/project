<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asamblea;
use App\Models\ParticipantsList;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Exceptions\AsambleaException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsambleaController
{
    public function index(){
        try {
            $asambleas = Asamblea::with("participantsLists")->get();
            return view("asamblea.index", ["asambleas" => $asambleas]);
        } catch (Exception $ex){
            Log::error("Error al cargar listado de asambleas " . $ex->getMessage());
            return redirect()->route('home')->with("error", $ex->getMessage());
        }
    }

    public function create(Request $request){
        DB::beginTransaction();
        try {
            if($request->input('date') <= Carbon::now()){
                throw new AsambleaException("Escoja una fecha mayor a la de hoy");
            }
            if(Asamblea::where("assembly_date", $request->input("date"))->exists()){
                throw new AsambleaException("Ya hay una asamblea convocada para esa fecha");
            }
            if(!in_array($request->input("type"), ['General', 'Extraordinaria'])) {
                throw new AsambleaException("El tipo de asamblea debe ser 'General' o 'Extraordinaria'");
            }

            $asamblea = new Asamblea;
            $asamblea->assembly_date = $request->input("date");
            $asamblea->type = $request->input("type");
            $asamblea->purpose = $request->input("purpose");
            $asamblea->save();

            DB::commit();
            return redirect()->route("asambleas")->with("success", "Asamblea convocada exitosamente");
        } catch(AsambleaException $ex){
            DB::rollBack();
            return redirect()->route("asamblea.create.view")->with("error", $ex->getMessage());
        } catch (Exception $ex){
            DB::rollBack();
            Log::error("Error al crear una asamblea " . $ex->getMessage());
            return redirect()->route("asamblea.create.view")->with("error", $ex->getMessage());
        }
    }

    public function detail($id){
        try {
            $asamblea = Asamblea::findOrFail($id);
            $participantsLists = ParticipantsList::with('user')->where("asamblea_id", $asamblea->id)->get();                  
            return view("asamblea.detail", 
                ["asamblea" => $asamblea, 
                "participantsLists" => $participantsLists]);
        } catch (AsambleaException $ex){
            return redirect()->route('asambleas')->with("error", $ex->getMessage());
        } catch (ModelNotFoundException $ex){
            Log::warning("No se encontro el id de la asamblea al cargar vista detail " . $ex->getMessage());
            return redirect()->route('asambleas')->with("error", $ex->getMessage());
        } catch (Exception $ex){
            Log::error("Error al intentar realizar baja logica de asamblea " . $ex->getMessage());
            return redirect()->route('asambleas')->with("error", $ex->getMessage());
        }
    }
}
