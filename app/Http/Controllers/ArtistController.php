<?php

namespace App\Http\Controllers;

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
        ]);

        return $response->json()['artists']['artist'] ?? [];
    }

    public function getArtist()
    {
        // Make a GET request to the Last.fm API to search for the artist
        $artistsResponse = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.getinfo',
            'mbid' => request()->mbid,
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        // Process the response and extract the relevant data
        $artist = $artistsResponse->json('artist');

        // Make a GET request to the Last.fm API to search for the artist top tracks
        $tracksResponse = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.gettoptracks',
            'mbid' => request()->mbid,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        // Process the response and extract the relevant data
        $topTracks = $tracksResponse->json('toptracks.track');

        // Make a GET request to the Last.fm API to search for the artist top albums
        $albumsResponse = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.gettopalbums',
            'mbid' => request()->mbid,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        // Process the response and extract the relevant data
        $topAlbums = $albumsResponse->json('topalbums.album');

        return Inertia::render('SingleArtist', [
            'artist' => $artist,
            'topTracks' => $topTracks,
            'topAlbums' => $topAlbums,
        ]);
    }

    public function searchArtist()
    {
        // Make a GET request to the Last.fm API to search for the artist
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.search',
            'artist' => request()->artist,
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        // Process the response and extract the relevant data
        $artist = $response->json('results.artistmatches.artist');

        return Inertia::render('SingleArtist', [
            'artist' => $artist,
        ]);
    }


}
