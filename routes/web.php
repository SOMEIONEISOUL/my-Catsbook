<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

Route::get("/", [HomeController::class,"ShowHomePage"])->name('home');

Route::prefix('posts')->group(function () {
    Route::get('/', [PostController::class,'showPosts'])->name('posts');
    Route::get('/top', [PostController::class,'showTopPosts'])->name('posts.top');
    Route::get('/create', [PostController::class,'createPost'])->name('posts.create')->middleware('auth');
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my')->middleware('auth');
    Route::post('/{post}/like', [LikeController::class, 'store'])->name('posts.like')->middleware('auth');
    Route::post('/', [PostController::class, 'storePost'])->name('posts.store');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');
    Route::get('/{post}', [PostController::class,'showPost'])->name('posts.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class,'showProfile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
Route::get('/profile/{id}', [ProfileController::class, 'showOtherProfile'])->name('profile.public');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store')->middleware('auth');
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');
Route::post('/comments/{comment}/like', [CommentLikeController::class, 'store'])->name('comments.like')->middleware('auth');

Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login_process',[AuthController::class,'login'])->name('login_process');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register_process', [AuthController::class, 'register'])->name('register_process');

Route::post('/logout',[AuthController::class,'logout'])->name('logout');

