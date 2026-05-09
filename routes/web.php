<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');

    Route::post('/media/{id}/planned', [LibraryController::class, 'addToPlanned'])->name('library.planned');

    Route::patch('/library/{id}/watched', [LibraryController::class, 'markAsWatched'])->name('library.watched');

    Route::delete('/library/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');
});

require __DIR__.'/auth.php';

Route::get('/media', [MediaController::class, 'index'])->name('media.index');