<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SongController extends Controller
{
    public static function getTopSongs()
    {
        // Make a GET request to the Last.fm API to get all top albums
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'chart.gettoptracks',
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        return $response->json()['tracks']['track'] ?? [];
    }

    public static function getArtistTopTracks($artistName)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.gettoptracks',
            'artist' => $artistName,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? ResponseController::formatResponse('artist-top-tracks', $response->json('toptracks.track')) : null;
    }

    public static function getTrackDuration()
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'track.getInfo',
            'mbid' => request()->get('mbid'),
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        return $response->json('track.duration');
    }
}
