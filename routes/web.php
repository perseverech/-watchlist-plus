<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MediaController::class, 'index'])->name('home');
Route::get('/media', [MediaController::class, 'index'])->name('media.index');
Route::get('/media/{id}', [MediaController::class, 'show'])->name('media.show');
Route::get('/search', [MediaController::class, 'search'])->name('media.search');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Library
    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
    Route::post('/media/{id}/planned', [LibraryController::class, 'addToPlanned'])->name('library.planned');
    Route::patch('/library/{id}/watched', [LibraryController::class, 'markAsWatched'])->name('library.watched');
    Route::delete('/library/{id}', [LibraryController::class, 'destroy'])->name('library.destroy');
    Route::post('/library/update', [UserController::class, 'updateStatus'])->name('library.update');

    // Reviews
    Route::post('/media/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Admin Routes 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{id}/block', [AdminController::class, 'block'])->name('admin.users.block');
    Route::get('/admin/logs', [AdminController::class, 'logs'])->name('admin.logs');
});

require __DIR__.'/auth.php';

/* If you are completely removing Laravel Breeze and want to use your custom 
auth controllers instead, comment out the "require" line above and uncomment these:

Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);
*/
