<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
});

require __DIR__.'/auth.php';

Route::get('/movies', [MovieController::class, 'index'])->name('movie.search');

Route::post('/watchlist', [MovieController::class, 'store'])->name('watchlist.store');

Route::get('list', [MovieController::class, 'watchlist'])->name('get.list');

Route::delete('/watchlist/{movie}', [MovieController::class, 'delete'])->name('watchlist.delete');

Route::get('/movies/{id}', [MovieController::class, 'show'])->name('movies.show');

Route::post('/movies/{id}/comment', [MovieController::class, 'storeComment'])->name('comments.store');

Route::get('/comments/{id}/edit', [MovieController::class, 'edit'])->name('comments.edit');

Route::put('/comments/{id}', [MovieController::class, 'update'])->name('comments.update');

Route::delete('/comments/{id}', [MovieController::class, 'destroyComment'])->name('comments.destroy');

