<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $sawService;

    public function __construct(SAWService $sawService)
    {
        $this->sawService = $sawService;
    }

    public function index()
    {
        $results = $this->sawService->calculate();
        return view('dashboard.index', compact('results'));
    }
}
