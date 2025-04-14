<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\PostController;
use App\Models\Post;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'welcome';
});

// Authenticated User Dashboard
Route::get('/dashboard', function () {
    $posts = Post::where('user_id', auth()->id())->latest()->get();
    return view('dashboard', compact('posts'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Post CRUD (My Posts)
    Route::resource('/myposts', UserPostController::class);
});

// Admin Routes (Authenticated + Admin Only)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('content', PostController::class);
});

// Auth Routes (from Laravel Breeze or Jetstream)
require __DIR__ . '/auth.php';
