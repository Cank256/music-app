<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SongController extends Controller
{
    /**
     * Retrieves the top songs from the Last.fm API.
     *
     * This method makes a GET request to the Last.fm API to fetch the top tracks.
     *
     * @return array An array of top tracks if found, otherwise an empty array.
     */
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

    /**
     * Retrieves the top tracks for a specific artist from the Last.fm API.
     *
     * This method makes a GET request to the Last.fm API to fetch the top tracks for a given artist.
     * The result is formatted using the `ResponseController::formatResponse` method.
     *
     * @param string $artistName The name of the artist for which to retrieve the top tracks.
     * @return \Illuminate\Http\Response|null A formatted response containing the top tracks, or null if the request was unsuccessful.
     */
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

    /**
     * Retrieves the duration of a specific track from the Last.fm API.
     *
     * This method makes a GET request to the Last.fm API to fetch the duration of a track
     * specified by its MBID (MusicBrainz Identifier).
     *
     * @return int|null The duration of the track in milliseconds, or null if the information is not found.
     */
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
