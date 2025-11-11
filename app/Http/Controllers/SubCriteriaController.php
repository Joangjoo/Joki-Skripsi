<?php

namespace App\Http\Controllers;

use App\Models\SubCriteria;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCriteriaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'name' => 'required',
            'value' => 'required|numeric|min:0'
        ]);

        SubCriteria::create($validated);
        return redirect()->route('criteria.index')->with('success', 'Sub Kriteria berhasil ditambahkan');
    }

    public function destroy(SubCriteria $subCriteria)
    {
        $subCriteria->delete();
        return redirect()->route('criteria.index')->with('success', 'Sub Kriteria berhasil dihapus');
    }
}
