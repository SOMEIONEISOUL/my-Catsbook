<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::get("/", [HomeController::class, "ShowHomePage"])->name('home');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class, 'showPosts'])->name('posts');
    Route::get('/top', [PostController::class, 'showTopPosts'])->name('posts.top');
    Route::get('/create', [PostController::class, 'createPost'])->name('posts.create')->middleware('auth');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my')->middleware('auth');
    Route::get('/{post}', [PostController::class, 'showPost'])->name('posts.show');
    Route::post('/', [PostController::class, 'storePost'])->name('posts.store')->middleware('auth');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');
    Route::post('/{post}/like', [LikeController::class, 'store'])->name('posts.like')->middleware('auth');
});

Route::middleware('auth')->prefix('comments')->group(function () {
    Route::post('/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/{comment}/like', [CommentLikeController::class, 'store'])->name('comments.like');
});

Route::prefix('profile')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
    Route::get('/{id}', [ProfileController::class, 'showOtherProfile'])->name('profile.public');
    Route::get('/', [ProfileController::class, 'showProfile'])->name('profile')->middleware('auth');
    Route::put('/', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login_process');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register_process');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});