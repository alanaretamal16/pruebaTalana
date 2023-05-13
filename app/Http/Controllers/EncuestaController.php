<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Color;
use App\Models\Encuesta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EncuestaController extends Controller
{
    public function index()
    {
        $encuestas = Encuesta::all();

        return Inertia::render('Encuestas/Index', [
            'encuestas' => $encuestas,
        ]);
    }

    public function create()
    {
        return Inertia::render('Encuestas/Create', [
            'colors' => Color::pluck('name', 'id'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'edad' => 'required|numeric',
            'color_id' => 'required|exists:colors,id',
        ]);
        $request['user_id'] = Auth::user()->id;
        Encuesta::create($request->all());

        return redirect('/encuestas');
    }

    public function show(Encuesta $encuesta)
    {
        return Inertia::render('Encuestas/Show', [
            'encuesta' => $encuesta,
        ]);
    }

    public function edit(Encuesta $encuesta)
    {
        return Inertia::render('Encuestas/Edit', [
            'encuesta' => $encuesta,
            'colors' => Color::all(),
        ]);
    }

    public function update(Request $request, Encuesta $encuesta)
    {
        $request->validate([
            'edad' => 'required|numeric',
            'color_id' => 'required|exists:colors,id',
        ]);

        $encuesta->update($request->all());

        return redirect('/encuestas');
    }

    public function destroy(Encuesta $encuesta)
    {
        $encuesta->delete();

        return redirect('/encuestas');
    }
    //cantidad de respuestas totales
    public function getTotalResponses()
    {
        $total = Encuesta::count();
        return response()->json(['total_responses' => $total]);
    }

    //respuestas por día
    public function getResponsesByDay()
    {
        $responsesByDay = Encuesta::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->get();

        return response()->json($responsesByDay);
    }

    //frecuencia de edades
    public function getAgeFrequency()
    {
        $ageFrequency = Encuesta::select('edad', DB::raw('count(*) as frequency'))
            ->groupBy('edad')
            ->get();

        return response()->json($ageFrequency);
    }

    //frecuencia de colores
    public function getColorFrequencies()
    {
        $colorFrequencies = Encuesta::select('color_id', DB::raw('count(*) as total'))
            ->groupBy('color_id')
            ->get();

        return response()->json($colorFrequencies);
    }

    //frecuencia de color por edad

    public function getColorFrequenciesByAge()
    {
        $colorFrequenciesByAge = Encuesta::select('edad', 'color_id', DB::raw('count(*) as total'))
            ->groupBy('edad', 'color_id')
            ->get();

        return response()->json($colorFrequenciesByAge);
    }
}
