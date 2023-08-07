<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
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

// HOME ROUTE
// Handles the landing page for the application
Route::get('/', [HomeController::class, 'index'])->name('home');

// SEARCH ROUTES
// Handles the creation and execution of searches
Route::get('/search', [SearchController::class, 'create'])->name('search');
Route::get('/searching', [SearchController::class, 'search'])->name('searching');

// ARTIST, ALBUM, AND SONG ROUTES
// Retrieve information about artists, albums, and songs
Route::get('/artist', [ArtistController::class, 'getArtist'])->name('get-artist');
Route::get('/album', [AlbumController::class, 'getAlbum'])->name('get-album');
Route::get('/song/{mbid}', [SongController::class, 'getSong'])->name('get-song');

// BROWSE ROUTES
// Browse various tags and categories
Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/tag', [BrowseController::class, 'getTag'])->name('get-tag');

// TRACK/SONG ROUTES
// Retrieve specific details about tracks or songs
Route::get('/track-duration', [SongController::class, 'getTrackDuration'])->name('track-duration');

// AUTHENTICATED USER ROUTES
// Routes that require user authentication
Route::middleware('auth')->group(function () {

    // DASHBOARD AND PROFILE ROUTES
    // Handles user dashboard and profile management
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile-edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // LIBRARY ROUTES
    // Access to user's personal library
    Route::get('/library', [FavoriteController::class, 'index'])->name('library');

    // FAVORITES ROUTES
    // Add and remove favorites
    Route::post('/favorite', [FavoriteController::class, 'add'])->name('add-favorite');
    Route::delete('/favorite', [FavoriteController::class, 'remove'])->name('remove-favorite');
});

// AUTHENTICATION ROUTES
// Include the additional authentication-related routes
require __DIR__.'/auth.php';
