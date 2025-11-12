<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comprobante;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ComprobanteException;
use Illuminate\Support\Facades\Log;
use Exception;

class ComprobanteController extends Controller
{
    public function store(Request $request)
    {
        try {
            if(!in_array($request->input("type"), 
                [   'Compensatorio', 
                    'Exonerante',
                    'Mensual'
                ]))
            {
                    throw new ComprobanteException('Tipo de comprobante invalido');
            }

            if($request->input('totalAmount') == 0 && $request->input("type") != 'Exonerante'){
                throw new ComprobanteException('Monto solo puede ser igual a cero cuando sube un comprobante Exonerante');
            }

            if($request->input("totalHours") <= 0 && $request->input("type") == 'Compensatorio'){
                throw new ComprobanteException('Ingrese un numero mayor a 0 para subir un comprobante compensatorio porfavor');
            }

            $user = Auth::user();
            if($user == null){
                throw new ComprobanteException('Usuario no valido');
            }
            
            Comprobante::create([
                'type' => $request->input("type"),
                'totalAmount' => $request->input("totalAmount"),
                'totalHours' => $request->input("totalHours"),
                'state' => 'Pending',
                'user_id' => $user->id()
            ]);
            return response()->json([
                'message' => 'Comprobante subido correctamente',
                'data' => $comprobante
            ], 201);
        } catch (ComprobanteException $ex) {
            Log::warning("ComprobanteException al crear comprobante " . $ex->getMessage());
            return response()->json([
                'message' => $ex->getMessage()
            ], 400);
        }  catch (Exception $ex) {
            Log::error("Error al crear comprobante " . $ex->getMessage());
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function pending()
    {
        try {
            $comprobantes = Comprobante::where('state', 'Pending')
                ->with('user')
                ->get();
            return response()->json($comprobantes);
        } catch (Exception $ex){
            Log::error("Error al mandar comprobantes " . $ex->getMessage());
            return response()->json([
                'message' => $ex->getMessage()
            ], 500);
        }
    }

    public function refuse($id)
    {
        $comprobante = Comprobante::findOrFail($id);
        $comprobante->update(['state' => 'Refused']);
        return response()->json(['message' => 'Comprobante rechazado']);
    }

    public function getComprobantesFromUser(){
        try{
            $comprobantes = Comprobante::where('user_id', Auth::id())->get();
            return response()->json([$comprobantes], 200);
        } catch (Exception $ex){
            Log::error('Error al devolver comprobantes de user ' . $ex->getMessage());
            return response()->json([$ex->getMessage()], 500);
        }
    }
}
