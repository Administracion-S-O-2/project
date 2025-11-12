<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Autenticacion
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = $request->header('Authorization');
            if($token == null){
                Log::error("Se intento acceder sin un token");
                return response()->json(["error" => "Invalid token"], 401);
            }

            $validacion = Http::withHeaders([
                        'Authorization' => $token,
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ])->get(getenv("API_AUTH_URL") . '/api/validate');

            if($validacion->status() != 200){
                Log::error("Se intento acceder sin un token");
                return response(["error" => "Invalid Token"],401);
            }

            $request->merge(['user' => $validacion->json()]);
            return $next($request);
        } catch (Exception $ex){
            Log::error("Ocurrio un error al autenticar token " . $ex->getMessage());
            return response()->json(["error" => "Ocurrio un error :("], 500);
        }
    }
}