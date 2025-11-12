<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Administrador;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AdminController
{
    public function profile(){
        try{
            $admin = Administrador::find(Auth::guard('admin')->id());
            return view('admin.profile', ["admin" => $admin]);
        } catch (Exception $ex){
            Log::error("Ocurrio un error al mostrar perfil de admin");
            return redirect()->route("home")->with("error", $ex->getMessage());
        }
    }

    public function create(){
        try{
            return view('admin.create');
        } catch (Exception $ex){
            Log::error("Ocurrio un error al cargar view crear admin " . $ex->getMessage());
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }

    public function store(Request $request){
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
 
            if (!Auth::attempt($credentials)) {
                throw new Exception('Credenciales invalidas');
            }

            $validator = $request->validate([
                'name' => ['required', 'min:3' , 'string', 'max:255'],
                'lastname' => ['required', 'min:3', 'string', 'max:255'],
                'new_admin_email' => ['required', 'email', 'unique:administradors,email'],
                'new_admin_password' => ['required', 'min:8', 'max:255'],
            ]);

            $admin = new Administrador();
            $admin->name = $request->input('name');
            $admin->lastname = $request->input('lastname');
            $admin->email = $request->input('new_admin_email');
            $admin->password = Hash::make($request->input('new_admin_password'));
            $admin->save();

            return redirect()
                    ->route('admin.create')
                    ->with('success', 'Administrador creado exitosamente');
        } catch (ValidationException $ex){
            Log::warning('Ocurrio un error al crear admin ' . $ex->getMessage());
            return redirect()->back()->withErrors($ex->errors())->withInput();
        } catch (Exception $ex){
            Log::error('Ocurrio un error al crear admin ' . $ex->getMessage());
            return redirect()-back()->with('error', $ex->getMessage());
        }
    }


}
