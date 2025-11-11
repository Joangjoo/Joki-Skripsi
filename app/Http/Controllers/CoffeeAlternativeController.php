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
        
        return view('coffee.create', );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        CoffeeAlternative::create($validated);
        return redirect()->route('coffee.index')->with('success', 'Alternatif biji kopi berhasil ditambahkan');
    }

    public function destroy(CoffeeAlternative $coffee)
    {
        $coffee->delete();
        return redirect()->route('coffee.index')->with('success', 'Alternatif berhasil dihapus');
    }
}
