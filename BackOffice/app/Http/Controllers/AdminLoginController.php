<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController
{
    public function loginView() 
    {
        return view('admin.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, true)) {
            $request->session()->regenerate();
            
            return redirect()->route('home');
        }

        return back()->with(['error' => 'Usuario o contraseña incorrectos']);
    }
    
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.view')->with("success", "Logout exitoso");
    }
}
