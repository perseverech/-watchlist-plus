<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// ==========================================
// PUBLIC ROUTES
// ==========================================
Route::get('/', [MediaController::class, 'index'])->name('home');
Route::get('/media', [MediaController::class, 'index'])->name('media.index'); 
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show');
Route::get('/search', [MediaController::class, 'search'])->name('media.search'); // AJAX Search

// Language switcher 
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'lt'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');


// ==========================================
// DASHBOARD (Breeze Default)
// ==========================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ==========================================
// AUTHENTICATED USER ROUTES
// ==========================================
Route::middleware('auth')->group(function () {
    
    // Profile (Breeze Default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // My Library (Pointed to your LibraryController!)
    Route::get('/library', [LibraryController::class, 'library'])->name('library');
    Route::post('/library/update', [LibraryController::class, 'updateStatus'])->name('library.update');
    Route::post('/library/remove', [LibraryController::class, 'removeFromLibrary'])->name('library.remove');

    // Reviews (AJAX endpoints)
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});


// ==========================================
// ADMIN ROUTES
// ==========================================
// ⚠️ Depends on Al'zhana creating the 'admin' middleware
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/block', [AdminController::class, 'block'])->name('admin.users.block');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');
});


// ==========================================
// BREEZE AUTHENTICATION ROUTES
// ==========================================
require __DIR__.'/auth.php';
