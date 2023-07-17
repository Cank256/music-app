<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ArtistController::class, 'getTopArtists'])->name('home');

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'artists' => ArtistController::getTopArtists()
//     ]);
// })->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//ARTIST ROUTES
Route::get('/artists/top', [ArtistController::class, 'getTopArtists']);
Route::get('/artists/search/{query}', [ArtistController::class, 'searchArtist']);

//AUTHENTICATED USER ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
