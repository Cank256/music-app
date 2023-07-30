<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
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
        // Define the initial parameters
        $parameters = [
            'method' => 'artist.getinfo',
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ];

        // Check if 'use' query parameter is set to 'mbid' and 'mbid' query parameter is provided
        if (request()->query('use') === 'mbid' && request()->query('mbid')) {
            $parameters['mbid'] = request()->query('mbid');
        }
        else if (request()->query('artist')) { // Fallback to using artist name
            $parameters['artist'] = request()->query('artist');
        }

        // Make a GET request to the Last.fm API to search for the artist
        $artistsResponse = Http::get(env('LASTFM_HOST'), $parameters);

        // Process the response and extract the relevant data
        $artist = $artistsResponse->json('artist');

        // Make the subsequent API requests using the artist's name
        $artistName = $artist['name'];

        $topTracks = SongController::getArtistTopTracks($artistName);
        $topAlbums = AlbumController::getArtistTopAlbums($artistName);
        $similarArtists = $this->getSimilarArtists($artistName);
        $favorite = Favorite::where('user_id', auth()->id())
                            ->where('artist_name', $artistName)
                            ->exists();

        return Inertia::render('SingleArtist', [
            'artist' => $artist,
            'topTracks' => $topTracks,
            'topAlbums' => $topAlbums,
            'similarArtists' => $similarArtists,
            'isFavorite' => $favorite ? true : false
        ]);
    }

    private function getSimilarArtists($artistName)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.getsimilar',
            'artist' => $artistName,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? $response->json('similarartists.artist') : null;
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
