<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MediaController::class, 'index'])->name('home');
Route::get('/media', [MediaController::class, 'index'])->name('media.index');
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show');
Route::get('/search', [MediaController::class, 'search'])->name('media.search');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ru'])) {
        session(['locale' => $locale]);
    }

    return back();
})->name('lang.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/library', [LibraryController::class, 'library'])->name('library');
    Route::post('/library/update', [LibraryController::class, 'updateStatus'])->name('library.update');
    Route::get('/library/update', [LibraryController::class, 'updateStatus'])->name('library.update.get');
    Route::post('/library/remove', [LibraryController::class, 'removeFromLibrary'])->name('library.remove');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/block', [AdminController::class, 'block'])->name('admin.users.block');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');
});

require __DIR__.'/auth.php';