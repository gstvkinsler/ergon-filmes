<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostFollowerController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('feed');
})->middleware(['auth', 'verified'])->name('feed');

Route::middleware('auth')->group(function () {
    Route::resources([
        'posts' => PostController::class,
    ]);
    Route::get('/', [PostController::class, 'index'])->name('feed');
    Route::post('/votes', [VoteController::class, 'store'])->name('votes.store');
    Route::post('/follow', [PostFollowerController::class, 'store'])->name('follow.store');
});

require __DIR__.'/auth.php';
