<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoAprobado;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\SolicitudAprobada;
use Illuminate\Support\Facades\Auth;

class NoAprobadoController
{
    
    public function Index(){
        try {
            $noAprobados = NoAprobado::where('state', 'Pending')->get();
            return view("noAprobado.index", ["noAprobados" => $noAprobados]);
        } catch (Exception $ex){
            Log::error("Error al cargar listado de solicitudes de registro " . $ex->getMessage());
            return redirect()->route('home')->with("error" , $ex->getMessage());
        }
    }

    public function approve($id){
        try {
            $noAprobado = NoAprobado::findOrFail($id);
            $noAprobado->administrador_id = Auth::guard('admin')->id();
            User::create([
                'name' => $noAprobado->name,
                'lastname' => $noAprobado->lastname,
                'email' => $noAprobado->email,
                'phone' => $noAprobado->phone,
                'password' => $noAprobado->password, 
                'email_verified_at' => now(), 
            ]);

            //Mail::to($noAprobado->email)->send(new SolicitudAprobada());

            $noAprobado->state = "Approved";
            $noAprobado->save();
            return redirect()->route('solicitudes')->with('success', 'Solicitud aprobada');
        } catch (ModelNotFoundException $ex){
            Log::warning("No se encontro id de solicitud a aprobar " . $ex->getMessage());
            return redirect()->route('solicitudes')->with("error", $ex->getMessage());
        } catch (Exception $ex){
            Log::error("Error al aprobar solicitud de registro " . $ex->getMessage());
            return redirect()->route('solicitudes')->with('error', $ex->getMessage());
        }
    }

    public function refuse($id){
        try {
            $noAprobado = NoAprobado::findOrFail($id);
            $noAprobado->administrador_id = Auth::guard('admin')->id();
            $noAprobado->state = "Refused";
            $noAprobado->save();
            return redirect()->route('solicitudes')->with('success', 'Solicitud rechazada');
        } catch (ModelNotFoundException $ex){
            Log::warning("No se encontro id de solicitud a rechazar " . $ex->getMessage());
            return redirect()->route('solicitudes')->with("error", $ex->getMessage());
        } catch (Exception $ex){
            Log::error("Error al rechazar solicitud de registro " . $ex->getMessage());
            return redirect()->route('solicitudes')->with('error', $ex->getMessage());
        }
    }

}
