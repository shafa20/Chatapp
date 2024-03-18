<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnePageController;

// Display all images and handle create operation
Route::get('/onepage', [OnePageController::class, 'index'])->name('onepage.index');
Route::post('/onepage', [OnePageController::class, 'store'])->name('onepage.store');

// Handle update operation
Route::put('/onepage/{onepage}', [OnePageController::class, 'update'])->name('onepage.update');

// Handle delete operation
Route::delete('/onepage/{onepage}', [OnePageController::class, 'destroy'])->name('onepage.destroy');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
