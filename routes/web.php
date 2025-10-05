<?php

use App\Http\Controllers\ComicController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComicFavoriteController;
use App\Http\Controllers\CommentController;
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
    Route::resource('comics', ComicController::class);
    Route::post('/comics/{comic}/like', [ComicFavoriteController::class, 'store'])->name('comics.like');
    Route::delete('/comics/{comic}/like', [ComicFavoriteController::class, 'destroy'])->name('comics.dislike');
    Route::resource('comics.comments', CommentController::class);
});

require __DIR__.'/auth.php';
