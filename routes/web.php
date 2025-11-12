<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SAWController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\SubCriteriaController;
use App\Http\Controllers\CoffeeAlternativeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('coffee.index');
});


// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Kriteria Routes
Route::prefix('criteria')->name('criteria.')->group(function () {
    Route::get('/', [CriteriaController::class, 'index'])->name('index');
    Route::post('/', [CriteriaController::class, 'store'])->name('store');
    Route::delete('/{criteria}', [CriteriaController::class, 'destroy'])->name('destroy');
});

// Sub Kriteria Routes
Route::prefix('sub-criteria')->name('sub-criteria.')->group(function () {
    Route::post('/', [SubCriteriaController::class, 'store'])->name('store');
    Route::delete('/{subCriteria}', [SubCriteriaController::class, 'destroy'])->name('destroy');
});

// Coffee Alternative Routes
Route::prefix('coffee')->name('coffee.')->group(function () {
    Route::get('/', [CoffeeAlternativeController::class, 'index'])->name('index');
    Route::get('/create', [CoffeeAlternativeController::class, 'create'])->name('create');
    Route::post('/', [CoffeeAlternativeController::class, 'store'])->name('store');
    Route::delete('/{coffee}', [CoffeeAlternativeController::class, 'destroy'])->name('destroy');
});

// Evaluation Routes
Route::prefix('evaluation')->name('evaluation.')->group(function () {
    Route::get('/', [EvaluationController::class, 'index'])->name('index');
    Route::get('/{coffee}/edit', [EvaluationController::class, 'edit'])->name('edit');
    Route::put('/{coffee}', [EvaluationController::class, 'update'])->name('update');
});

// SAW Result
Route::get('/saw-result', [SAWController::class, 'index'])->name('saw.result');
