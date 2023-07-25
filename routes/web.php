<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

//SEARCH ROUTES
Route::get('/search', [SearchController::class, 'create'])->name('search');
Route::get('/searching', [SearchController::class, 'search'])->name('searching');
Route::get('/not-searching', [SearchController::class, 'notSearching'])->name('not-searching');
Route::get('/search/artist', [ArtistController::class, 'getArtist'])->name('search-artist');
Route::get('/search/album', [AlbumController::class, 'getAlbum'])->name('search-album');
Route::get('/search/song/{mbid}', [SongController::class, 'getSong'])->name('search-song');

//BROWSE ROUTES
Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/tag', [BrowseController::class, 'getTag'])->name('get-tag');

//AUTHENTICATED USER ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
