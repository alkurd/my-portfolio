<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Publieke pagina index en detail (zonder login)
Route::get('/pages', [PageController::class, 'indexPublic'])->name('pages.public.index');
Route::get('/pages/{slug}', [PageController::class, 'showPublic'])->name('pages.public.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PageController::class, 'index'])->name('dashboard');
    
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
