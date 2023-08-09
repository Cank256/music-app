<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;

class HomeController extends Controller
{
    /**
     * Renders the home page with top albums and artists.
     *
     * Fetches the top albums and artists by calling the respective methods from AlbumController and ArtistController.
     * Renders the 'Home' view with the retrieved data, providing an overview of the top albums and artists.
     * Note that the functionality to fetch top songs has been commented out and can be extended in the future.
     *
     * @return \Inertia\Response An Inertia response containing the top albums and artists to be displayed on the home page.
     */
    public function index()
    {
        $topAlbums = AlbumController::getTopAlbums();
        $topArtists = ArtistController::getTopArtists();
        // $topSongs = SongController::getTopSongs();

        return Inertia::render('Home', [
            'topAlbums' => $topAlbums,
            'topArtists' => $topArtists,
            // 'topSongs' => $topSongs
        ]);
    }

    /**
     * Renders the dashboard page with top albums and artists.
     *
     * Similar to the index method, this method fetches the top albums and artists by calling the respective methods from AlbumController and ArtistController.
     * Renders the 'Home' view with the retrieved data, providing a user-specific dashboard view of the top albums and artists.
     * Note that the functionality to fetch top songs has been commented out and can be extended in the future.
     *
     * @return \Inertia\Response An Inertia response containing the top albums and artists to be displayed on the dashboard page.
     */
    public function dashboard()
    {
        $topAlbums = AlbumController::getTopAlbums();
        $topArtists = ArtistController::getTopArtists();
        // $topSongs = SongController::getTopSongs();

        return Inertia::render('Home', [
            'topAlbums' => $topAlbums,
            'topArtists' => $topArtists,
            // 'topSongs' => $topSongs
        ]);
    }
}
