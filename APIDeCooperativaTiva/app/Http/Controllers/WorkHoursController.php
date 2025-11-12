<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkHours;
use Illuminate\Support\Facades\Auth;

class WorkHoursController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $workHours = WorkHours::where('user_id', $userId)->get();

        return response()->json($workHours);
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'date' => 'required|date',
            'hours' => 'required|integer|min:0|max:24',
        ]);

        $workHours = WorkHours::create([
            'user_id' => $request['user']['id'],
            'date' => $validated['date'],
            'hours' => $validated['hours']
        ]);

        return response()->json([
            'message' => 'Horas registradas correctamente.',
            'data' => $workHours
        ], 201);
    }
}