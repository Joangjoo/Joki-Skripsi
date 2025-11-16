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
        $totalWeight = $criteria->sum('weight');
        $countCriteria = $criteria->count();
        return view('criteria.index', compact('criteria', 'totalWeight', 'countCriteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:criterias',
            'name' => 'required',
            'weight' => 'required|numeric|min:0|min:0',
            'type' => 'required|in:benefit,cost'
        ]);

        $totalWeight = Criteria::sum('weight');

        if ($totalWeight + $request->weight > 1) {
            return redirect()->route('criteria.index')
                ->with('error', 'Total bobot melebihi 1. Kurangi bobot kriteria.');
        }

        Criteria::create($validated);

        $newTotal = Criteria::sum('weight');

        if ($newTotal < 1) {
            return redirect()->route('criteria.index')
                ->with('warning', 'Total bobot masih kurang ' . number_format(1 - $newTotal, 2));
        } elseif ($newTotal == 1) {
            return redirect()->route('criteria.index')
                ->with('info', 'Total bobot valid! Sudah pas 1');
        }

        return redirect()->route('criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }



    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('criteria.index')->with('success', 'Kriteria berhasil dihapus');
    }
}
