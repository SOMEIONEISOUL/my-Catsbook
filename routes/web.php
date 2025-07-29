<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::get("/", [HomeController::class,"ShowHomePage"])->name('home');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class,'showPosts'])->name('posts');
    Route::get('/create', [PostController::class,'createPost'])->name('posts.create');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my')->middleware('auth');
    Route::post('/', [PostController::class, 'storePost'])->name('posts.store');
    Route::delete('/{id}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');
    Route::get('/{id}', [PostController::class,'showPost'])->name('posts.show');
});

Route::get('/profile', [ProfileController::class,'showProfile'])->name('profile');

Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login_process',[AuthController::class,'login'])->name('login_process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register_process', [AuthController::class, 'register'])->name('register_process');

Route::post('/logout',[AuthController::class,'logout'])->name('logout');
