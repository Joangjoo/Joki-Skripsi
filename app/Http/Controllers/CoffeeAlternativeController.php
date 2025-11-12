<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeAlternative;
use App\Http\Controllers\Controller;

class CoffeeAlternativeController extends Controller
{
    public function index()
    {
        $coffees = CoffeeAlternative::all();
        return view('coffee.index', compact('coffees'));
    }

    public function create()
    {
        $coffees = CoffeeAlternative::all();
        return view('coffee.create', compact('coffees') );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $coffee = CoffeeAlternative::create($validated);
        return redirect()->route('evaluation.edit', $coffee)
        ->with('success', 'Alternatif biji kopi berhasil ditambahkan, silakan lakukan penilaian.');
    }

    public function destroy(CoffeeAlternative $coffee)
    {
        $coffee->delete();
        return redirect()->route('coffee.index')->with('success', 'Alternatif berhasil dihapus');
    }
}
