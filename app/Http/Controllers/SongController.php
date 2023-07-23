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
}
