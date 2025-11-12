<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function CambiarPassword(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'current_password' => 'required|string',
                'password' => 'required|string|confirmed|min:6'
            ]);

            $user = User::find($request->id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'La contraseña actual es incorrecta.'], 422);
            }

            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json(['message' => 'Contraseña actualizada correctamente.'], 200);
        } catch (Exception $ex){
            Log::error("Ocurrio un error al cambiar password " . $ex->getMessage());
            return response()->json(['error' => 'Lo sentimos, ocurrio un error :(']);
        }
    }

    public function ValidateToken(Request $request)
    {
        return auth('api')->user();
    }

    public function Logout(Request $request)
    {
        try {
            $request->user()->token()->revoke();
            return response()->json(['message' => 'Token Revoked'], 200);
        } catch (Exception $ex){
            Log::error("Ocurrio un error al hacer logout " . $ex->getMessage());
            return response()->json(['error' => 'Lo sentimos, ocurrio un error :(']);
        }
    }

    public function BuscarParaEditar($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            return response()->json(['user' => $user], 200);
        } catch (Exception $ex){
            Log::error("Ocurrio un error al hacer buscar para editar method" . $ex->getMessage());
            return response()->json(['error' => 'Lo sentimos, ocurrio un error :(']);
        }
    }

    public function Editar(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'nullable|string|max:15',
                'lastname' => 'nullable|string|max:255',
                'password' => 'nullable|string|confirmed'
            ]);

            $user = User::find($request->id);

            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado.'], 404);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->lastname = $request->lastname;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return response()->json(['message' => 'Usuario actualizado correctamente.'], 200);
        } catch (Exception $e) {
            Log::error("Ocurrio un error al editar user " . $ex->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
    }

