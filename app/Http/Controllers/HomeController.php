<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;

class HomeController extends Controller
{
    public function index()
    {
        $topAlbums = AlbumController::getTopAlbums();
        $topArtists = ArtistController::getTopArtists();

        return Inertia::render('Welcome', [
            'topAlbums' => $topAlbums,
            'topArtists' => $topArtists
        ]);
    }
}
