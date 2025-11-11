<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::with('subCriteria')->get();
        return view('criteria.index', compact('criteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:criterias',
            'name' => 'required',
            'weight' => 'required|numeric|min:0|max:1',
            'type' => 'required|in:benefit,cost'
        ]);

        Criteria::create($validated);
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
