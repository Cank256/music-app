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
