<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
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
        ]);

        return $response->json()['albums']['album'] ?? [];
    }

    public function getAlbum()
    {
        // Make a GET request to the Last.fm API to search for the artist
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'album.getinfo',
            'album' => request()->query('album'),
            'artist' => request()->query('artist'),
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        // Process the response and extract the relevant data
        $album = $response->json('album');

        $similarAlbums = $this->getSimilarAlbums($album['tags']['tag'][0]['name']);
        $releaseDate = WebScrapingController::getReleaseDate($album['url']);
        $favorite = Favorite::where('content', $album['name'].'_'.$album['artist'])->exists();

        return Inertia::render('SingleAlbum', [
            'album' => $album,
            'similarAlbums' => $similarAlbums,
            'releaseDate' => $releaseDate,
            'isFavorite' => $favorite ? true : false
        ]);
    }

    public static function getArtistTopAlbums($artistName)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.gettopalbums',
            'artist' => $artistName,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? $response->json('topalbums.album') : null;
    }

    public function getSimilarAlbums($tag)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'tag.gettopalbums',
            'tag' => $tag,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? $response->json('albums.album') : null;
    }

}
