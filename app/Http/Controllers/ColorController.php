<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();

        return Inertia::render('Colors/Index', [
            'colors' => $colors,
        ]);
    }

    public function create()
    {
        return Inertia::render('Colors/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',

        ]);

        Color::create($request->all());

        return redirect('/colors');
    }

    public function show(Color $color)
    {
        return Inertia::render('Colors/Show', [
            'color' => $color,
        ]);
    }

    public function edit(Color $color)
    {
        return Inertia::render('Colors/Edit', [
            'color' => $color,
        ]);
    }

    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $color->update($request->all());

        return redirect('/colors');
    }

    public function destroy(Color $color)
    {
        $color->delete();

        return redirect('/colors');
    }
}
