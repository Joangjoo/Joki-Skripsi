<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\CoffeeAlternative;
use App\Http\Controllers\Controller;

class EvaluationController extends Controller
{
    public function index()
    {
        $coffees = CoffeeAlternative::with('evaluations.criteria', 'evaluations.subCriteria')->get();
        $criteria = Criteria::with('subCriteria')->get();
        return view('evaluation.index', compact('coffees', 'criteria'));
    }

    public function edit(CoffeeAlternative $coffee)
    {
        $criteria = Criteria::with('subCriteria')->get();
        $evaluations = $coffee->evaluations->keyBy('criteria_id');
        return view('evaluation.edit', compact('coffee', 'criteria', 'evaluations'));
    }

    public function update(Request $request, CoffeeAlternative $coffee)
    {
        $request->validate([
            'evaluations' => 'required|array',
            'evaluations.*' => 'required|exists:sub_criterias,id'
        ]);

        foreach ($request->evaluations as $criteriaId => $subCriteriaId) {
            Evaluation::updateOrCreate(
                [
                    'coffee_alternative_id' => $coffee->id,
                    'criteria_id' => $criteriaId
                ],
                [
                    'sub_criteria_id' => $subCriteriaId
                ]
            );
        }

        return redirect()->route('evaluation.index')->with('success', 'Penilaian berhasil disimpan');
    }
}
