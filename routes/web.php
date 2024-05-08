<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// productions
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/productions', [ProductionController::class, 'index'])->name('productions');
    Route::get('/productions/create', [ProductionController::class, 'create'])->name('productions.create');
    Route::post('/productions', [ProductionController::class, 'store'])->name('productions.store');
    Route::get('/productions/{production}/edit', [ProductionController::class, 'edit'])->name('productions.edit');
    Route::put('/productions/{production}', [ProductionController::class, 'update'])->name('productions.update');
    Route::delete('/productions/{production}', [ProductionController::class, 'destroy'])->name('productions.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
