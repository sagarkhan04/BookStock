<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('backend/dashboard');
    })->name('dashboard');

    // Book routes
    Route::resource('books', BookController::class);

    // Author routes
    Route::resource('authors', AuthorController::class);
    Route::post('/authors/{author}/toggle-status', [AuthorController::class, 'toggleStatus'])->name('authors.toggle-status');

    // Category routes
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    // Profile routes
    Route::get('/profile/edit', [ProfileController::class, 'showEditProfile'])->name('edit-profile');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('update-profile');
    Route::get('/password/change', [ProfileController::class, 'showChangePassword'])->name('change-password');
    Route::post('/password/update', [ProfileController::class, 'changePassword'])->name('update-password');

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
