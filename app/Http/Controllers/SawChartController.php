<?php

namespace App\Http\Controllers;

use App\Models\HasilSaw;

class SawChartController extends Controller
{
    public function index()
    {
        $data = HasilSaw::orderBy('rank')->get();

        $labels = $data->pluck('alternative_name');
        $scores = $data->pluck('score');

        return view('saw.chart', compact('labels', 'scores'));

    }
}

