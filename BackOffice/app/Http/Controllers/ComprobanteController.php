<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comprobante;
use Exception;
use App\Exceptions\AsambleaException;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ComprobanteController
{
    public function pendingComprobantes(){
        try {
            $comprobantes =  Comprobante::where('state', 'Pending')
                                ->with('User')
                                ->get();
            return view("comprobante.pendingComprobantes", ["comprobantes" => $comprobantes]);
        } catch (Exception $ex){
            Log::error("Ocurrio un error al cargar comprobantes pendientes" . $ex->getMessage());
            return redirect()->route('home')->with('error', $ex->getMessage()); 
        }
    }

    public function approve($id){
        try {
            $comprobante = Comprobante::findOrFail($id);
            $comprobante->administrador_id = Auth::guard('admin')->id();
            $comprobante->state = "Approved";
            $comprobante->dateManaged = Carbon::now();
            $comprobante->save();
            return redirect()->back()->with('success', 'Aprobacion exitosa'); 
        }  catch(ModelNotFoundException $ex){
            Log::warning("Id de comprobante no encontrado en aprobacion " . $ex->getMessage());
            return redirect()->route('pending.comprobantes')->with('error', $ex->getMessage()); 
        } catch (Exception $ex){
            Log::error("Ocurrio un error al aprobar comprobante" . $ex->getMessage());
            return redirect()->route('pending.comprobantes')->with('error', $ex->getMessage()); 
        }
    }

    public function refuse($id){
        try {
            $comprobante = Comprobante::findOrFail($id);
            $comprobante->administrador_id = Auth::guard('admin')->id();
            $comprobante->state = "Refused";
            $comprobante->dateManaged = Carbon::now();
            $comprobante->save();
            return redirect()->back()->with('success', 'Rechazo exitoso'); 
        } catch(ModelNotFoundException $ex){
            Log::warning("Id de comprobante no encontrado en rechazo " . $ex->getMessage());
            return redirect()->route('pending.comprobantes')->with('error', $ex->getMessage()); 
        } catch (Exception $ex){
            Log::error("Ocurrio un error" . $ex->getMessage());
            return redirect()->route('pending.comprobantes')->with('error', $ex->getMessage()); 
        }
    }
}
