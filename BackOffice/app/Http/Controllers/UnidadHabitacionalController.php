<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnidadHabitacional;
use App\Models\Etapa;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Exceptions\UnidadHabitacionalException;
use Illuminate\Support\Facades\DB;

class UnidadHabitacionalController
{
    public function Index(){
        try {
            $unidades =  UnidadHabitacional::with(['users', 'etapa'])->get();
            return view("unidad.index", ["unidades" => $unidades]);
        } catch (Exception $ex){
            Log::error("Error al cargar listado de unidades habitacionales " . $ex->getMessage());
            return redirect()->route('home')->with('error', $ex->getMessage());
        }
    }

    public function create(){
        try {
            $etapas = Etapa::all();
            return view("unidad.create", ["etapas" => $etapas]);
        } catch (Exception $ex){
            Log::error("Error al cargar vista para crear unidad habitacional " . $ex->getMessage());
            return redirect()->route('unidades')->with('error', $ex->getMessage());
        }
    }
    
    public function store(Request $request){
        DB::beginTransaction();
        try {
            if(UnidadHabitacional::where("door", $request->input("door"))->exists()){
                throw new UnidadHabitacionalException("Ya existe una unidad habitacional con ese numero de puerta");
            }
            if(!Etapa::find($request->input('etapa_id'))){
                throw new UnidadHabitacionalException("Seleccion una etapa valida");
            }

            $unidad = new UnidadHabitacional;
            $unidad->street = $request->input("street");;
            $unidad->door = $request->input("door");;
            $unidad->etapa_id = $request->input("etapa_id");; 
            $unidad->save();
            DB::commit();
            return redirect()->route('unidades')->with('success', "Unidad creada exitosamente");
        } catch (UnidadHabitacionalException $ex){
            DB::rollBack();
            return redirect()->route('unidad.create.view')->with("error", $ex->getMessage());
        } catch (Exception $ex){
            DB::rollBack();
            Log::error("Error al crear nueva unidad habitacional " . $ex->getMessage());
            return redirect()->route('unidad.create.view')->with('error', $ex->getMessage());
        }
    }

    public function assigne($id){
        try {
            $users = User::where("unidad_habitacional_id", null)->get();
            $unidad = UnidadHabitacional::with("etapa")->findOrFail($id);
            return view("unidad.assigneUnidad", ["users" => $users, "unidad" => $unidad]);
        } catch (ModelNotFoundException $ex) {
            Log::warning("No se encontro el id de la unidad habitacional al mostrar vista de asignacion de socios " . $ex->getMessage());
            return redirect()->route('unidades')->with("error", "Asamblea no encontrada");
        } catch (Exception $ex){
            Log::error("Error al asignar una unidad habitacional a socio " . $ex->getMessage());
            return redirect()->route('unidades')->with('error', $ex->getMessage());
        }
    }

    public function detail($id){
        try {
            $unidad = UnidadHabitacional::with('etapa')->findOrFail($id);
            $users = User::where("unidad_habitacional_id", $id)->get();
            $etapas = Etapa::all();
            return view("unidad.details", ["users" => $users, "unidad" => $unidad, "etapas" => $etapas]);
        } catch (ModelNotFoundException $ex) {
            Log::warning("No se encontro el id de la unidad habitacional al ver detalles de unidad " . $ex->getMessage());
            return redirect()->route('unidades')->with("error", "Unidad no encontrada");
        } catch (Exception $ex){
            Log::error("Ocurrio un error" . $ex->getMessage());
            return redirect()->route('unidades')->with('error', $ex->getMessage());
        }
    }

    public function update(Request $request){
        DB::beginTransaction();
        try {
            $detailUrl = "/unidad/detail/" . $request->input('id');
            $unidad = UnidadHabitacional::findOrFail($request->input("id"));
            $etapa = Etapa::findOrFail($request->input('etapa_id'));
            
            $unidad->etapa_id = $request->input('etapa_id'); 
            $unidad->door = $request->input('door');
            $unidad->street = $request->input('street');
            $unidad->save();
            DB::commit();
            return redirect($detailUrl)->with('success', "Actualizacion exitosa");
        } catch (UnidadHabitacionalException $ex){
            DB::rollBack();
            return redirect($detailUrl)->with("error", $ex->getMessage());
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            Log::warning("Error al realizar update de unidad habitacional " . $ex->getMessage());
            return redirect($detailUrl)->with("error", $ex->getMessage());
        } catch (Exception $ex){
            DB::rollBack();
            Log::error("Ocurrio un error al realizar update de unidad habitacional" . $ex->getMessage());
            return redirect($detailUrl)->with("error", $ex->getMessage());
        }
    }

}
