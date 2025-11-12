<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etapa;
use Exception;
use App\Exceptions\EtapaException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EtapaController
{

    public function create(){
        return view("etapa.create");
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $name = $request->input('name');
            $description = $request->input('description');

            if(Etapa::where('name', $name)->exists()){
                throw new EtapaException("Ya existe una etapa con ese nombre, escoja otro porfavor");
            }
            if(Etapa::where('description', $description)->exists()){
                throw new EtapaException("Ya existe una etapa con esa descripcion, escoja otra porfavor");
            }

            $etapa = new Etapa;
            $etapa->name = $name;
            $etapa->description = $description;
            $etapa->save();
            DB::commit();
            return redirect()->route('etapa.create.view')->with('success', 'Etapa creada exitosamente');
        } catch (EtapaException $ex){
            DB::rollBack();
            Log::error("Error al crear nueva etapa " . $ex->getMessage());
            return redirect()->route('etapa.create.view')->with('error', $ex->getMessage());
        } catch (Exception $ex){
            DB::rollBack();
            Log::error("Error al crear nueva etapa " . $ex->getMessage());
            return redirect()->route('etapa.create.view')->with('error', $ex->getMessage());
        }
    }

}
