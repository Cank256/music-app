<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ArtistController extends Controller
{
    public static function getTopArtists()
    {
        // Make a GET request to the Last.fm API to get the top artists
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'chart.getTopArtists',
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
            'limit' => 5,
        ]);

        return $response->json()['artists']['artist'] ?? [];
    }

    public function searchArtist($query)
    {
        // Make a GET request to the Last.fm API to search for the artist
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.search',
            'artist' => $query,
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        // Process the response and extract the relevant data
        $artists = $response->json('results.artistmatches.artist');

        return response()->json($artists);
    }


}
