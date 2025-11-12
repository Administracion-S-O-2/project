<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidarId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $id = $request->route('id');
        if ($id === null) {
            return redirect()->back()->with('error', 'ID no proporcionado');
        }
        if (!is_numeric($id)) {
            return redirect()->back()->with('error', 'ID debe ser un número válido');
        }
        if ($id <= 0) {
            return redirect()->back()->with('error', 'ID debe ser mayor a cero');
        }
        return $next($request);
    }
}
