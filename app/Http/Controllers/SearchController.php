<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\SongController;

class SearchController extends Controller
{
    /**
     * Creates and returns the initial search page.
     *
     * This method retrieves the top albums, artists, and songs, and sends them to the 'Search' view
     * via Inertia. It also ensures that the 'isSearching' session variable is forgotten.
     *
     * @return \Inertia\Response The Inertia response containing the view and data.
     */
    public function create(): Response
    {
        $topAlbums = AlbumController::getTopAlbums();
        $topArtists = ArtistController::getTopArtists();
        $topSongs = SongController::getTopSongs();

        session()->forget('isSearching');

        return Inertia::render('Search', [
            'action' => 'search',
            'topAlbums' => $topAlbums,
            'topArtists' => $topArtists,
            'topSongs' => $topSongs
        ]);
    }

    /**
     * Performs a search for artists and albums based on a user's query.
     *
     * This method takes a search query from the request, constructs URLs to perform searches
     * for artists and albums using the Last.fm API, and sends back a JSON response with the results.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the search query.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the search results for artists and albums.
     */
    public function search(Request $request)
    {
        $apiKey = env('LASTFM_API_KEY');
        $searchQuery = $request->get('searchQuery');
        $artistUrl = env('LASTFM_HOST')."?method=artist.search&artist={$searchQuery}&api_key={$apiKey}&limit=10&format=json";
        $albumUrl = env('LASTFM_HOST')."?method=album.search&album={$searchQuery}&api_key={$apiKey}&limit=10&format=json";

        $artistResponse = Http::get($artistUrl);
        $albumResponse = Http::get($albumUrl);

        return response()->json([
            'artists' => $artistResponse->json('results.artistmatches.artist'),
            'albums' => $albumResponse->json('results.albummatches.album'),
        ]);
    }
}
