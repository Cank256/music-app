<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public static function getTopAlbums()
    {
        // Make a GET request to the Last.fm API to get all top albums
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'tag.gettopalbums',
            'api_key' => env('LASTFM_API_KEY'),
            'tag' => 'rnb',
            'format' => 'json',
            'limit' => 5
        ]);

        return $response->json()['albums']['album'] ?? [];
    }

}
