<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ActorController;
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
Route::middleware(['auth', 'verified'])->prefix('productions')->group(function () {
    Route::get('/', [ProductionController::class, 'index'])->name('productions');
    Route::get('/all', [ProductionController::class, 'productions'])->name('productions.name');
    Route::get('/create', [ProductionController::class, 'create'])->name('productions.create');
    Route::post('/', [ProductionController::class, 'store'])->name('productions.store');
    Route::get('/{production}/edit', [ProductionController::class, 'edit'])->name('productions.edit');
    Route::put('/{production}', [ProductionController::class, 'update'])->name('productions.update');
    Route::delete('/{production}', [ProductionController::class, 'destroy'])->name('productions.destroy');
});

// movies
Route::middleware(['auth', 'verified'])->prefix('movies')->group(function () {
    Route::get('/', [MovieController::class, 'index'])->name('movies');
    Route::get('/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
});

// actors
Route::middleware(['auth', 'verified'])->prefix('actors')->group(function () {
    Route::get('/', [ActorController::class, 'index'])->name('actors');
    Route::get('/all', [ActorController::class, 'allActors'])->name('actors.name');
    Route::get('/create', [ActorController::class, 'create'])->name('actors.create');
    Route::post('/', [ActorController::class, 'store'])->name('actors.store');
    Route::get('/{actor}/edit', [ActorController::class, 'edit'])->name('actors.edit');
    Route::put('/{actor}', [ActorController::class, 'update'])->name('actors.update');
    Route::delete('/{actor}', [ActorController::class, 'destroy'])->name('actors.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
