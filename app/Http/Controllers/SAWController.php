<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use App\Models\HasilSaw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SAWController extends Controller
{
    protected $sawService;

    public function __construct(SAWService $sawService)
    {
        $this->sawService = $sawService;
    }

    public function index()
    {
        // 1. Hitung SAW
        $results = $this->sawService->calculate();

        // 2. Simpan ke database (pindahkan dari SAWService ke sini)
        HasilSaw::truncate();

        foreach ($results as $r) {
            HasilSaw::create([
                'alternative_id' => $r['id'],
                'alternative_name' => $r['name'],
                'score' => $r['score'],
                'rank' => $r['rank'],
            ]);
        }

        // 3. Tampilkan hasil ke halaman
        return view('saw.result', compact('results'));
    }
}
