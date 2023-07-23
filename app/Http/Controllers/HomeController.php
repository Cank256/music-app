<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;

class HomeController extends Controller
{
    public function index()
    {
        $topAlbums = AlbumController::getTopAlbums();
        $topArtists = ArtistController::getTopArtists();
        $topSongs = SongController::getTopSongs();

        return Inertia::render('Home', [
            'topAlbums' => $topAlbums,
            'topArtists' => $topArtists,
            'topSongs' => $topSongs
        ]);
    }

    public function dashboard()
    {
        $topAlbums = AlbumController::getTopAlbums();
        $topArtists = ArtistController::getTopArtists();
        $topSongs = SongController::getTopSongs();

        return Inertia::render('Home', [
            'topAlbums' => $topAlbums,
            'topArtists' => $topArtists,
            'topSongs' => $topSongs
        ]);
    }
}
