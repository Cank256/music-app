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

    public function search(Request $request)
    {
        $apiKey = env('LASTFM_API_KEY');
        $searchQuery = $request->get('searchQuery');
        $artistUrl = env('LASTFM_HOST')."?method=artist.search&artist={$searchQuery}&api_key={$apiKey}&format=json";
        $albumUrl = env('LASTFM_HOST')."?method=album.search&album={$searchQuery}&api_key={$apiKey}&format=json";

        $artistResponse = Http::get($artistUrl);
        $albumResponse = Http::get($albumUrl);

        // Store isSearching status in session
        $request->session()->put('isSearching', true);

        return Inertia::render('SearchResults', [
            'artists' => $artistResponse->json('results.artistmatches.artist'),
            'albums' => $artistResponse->json('results.albummatches.album'),
        ]);
    }

    public function notSearching(Request $request)
    {
        return $request->session()->forget('isSearching');
    }
}
