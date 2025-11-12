<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NoAprobado;
use Illuminate\Support\Facades\Hash;
use Exception;
use App\Exceptions\NoAprobadoException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; 

class NoAprobadoController extends Controller
{
    public function create(Request $request){
        DB::beginTransaction();
        try {
            $validation = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'lastname' => 'nullable|string|max:255',
                'email' => 'required|email|unique:no_aprobados,email|max:255',
                'password' => 'required|string|confirmed|min:8',
            ]);

            if ($validation->fails()) {
                throw new NoAprobadoException($validation->errors());
            }
            
            $solicitud = NoAprobado::create([
                'name' => $request->input("name"),
                'lastname' => $request->input("lastname"),
                'password' => Hash::make($request->input("password")),
                'email' => $request->input("email")
            ]);

            DB::commit();
            return response()->json([
                'message' => 'Registro exitoso',
                'solicitud' => $solicitud
            ], 201);
        } catch (NoAprobadoException $ex){
            DB::rollBack();
            Log::warning("Error al validar solicitud " . $ex->getMessage());
            return response()->json(['error' => $ex->getMessage()], 401);   
        }catch (Exception $ex){
            DB::rollBack();
            Log::error("Error al registrar solicitud " . $ex->getMessage());
            return response()->json(['error' => $ex->getMessage()], 500);   
        }
    }
}
