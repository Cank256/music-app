<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class ArtistController extends Controller
{
    /**
     * Retrieves the top artists from Last.fm's API.
     *
     * Initiates a GET request to Last.fm using the 'chart.getTopArtists' method, using the host and API key defined in the environment variables.
     * The response is expected in JSON format, and the method extracts and returns the array of top artists.
     * If the 'artists' array is not found in the response, an empty array is returned, ensuring graceful handling of unexpected response formats.
     *
     * @return array An array containing the details of the top artists or an empty array if not found.
     */
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

    /**
     * Retrieves detailed information about a specific artist including top tracks, top albums, similart artists, and favorite status.
     *
     * The method initiates a GET request to Last.fm's API using the 'artist.getinfo' method, passing the album and artist names obtained from the request query.
     * It then processes the response and extracts relevant album data, formats the response through ResponseController, and gets similar albums using a private method.
     * The release date is retrieved through web scraping using the WebScrapingController.
     * It also checks if the album is marked as a favorite by the authenticated user.
     * Finally, it renders the 'SingleAlbum' view, passing along all the retrieved information.
     *
     * @return \Inertia\Response An Inertia response containing the artist details, artist's top tracks, artist's top albums, similar artists, and and favorite status.
     */
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
        $artist = ResponseController::formatResponse('artist', $artistsResponse->json('artist'))->getData();

        // Make the subsequent API requests using the artist's name
        $artistName = $artist->name;

        $topTracks = SongController::getArtistTopTracks($artistName);
        $topAlbums = AlbumController::getArtistTopAlbums($artistName);
        $similarArtists = $this->getSimilarArtists($artistName);
        $favorite = Favorite::where('user_id', auth()->id())
                            ->where('artist_name', $artistName)
                            ->exists();

        // return $similarArtists;
        return Inertia::render('SingleArtist', [
            'artist' => $artist,
            'topTracks' => $topTracks,
            'topAlbums' => $topAlbums,
            'similarArtists' => $similarArtists,
            'isFavorite' => $favorite ? true : false
        ]);
    }

    /**
     * Retrieves similar artists to a specified artist from Last.fm's API.
     *
     * Initiates a GET request to Last.fm using the 'artist.getsimilar' method, passing the artist name, and limiting the result to 10 similar artists.
     * If the request is successful, the response is formatted using the ResponseController, and the array of similar artists is returned.
     * If the request fails, null is returned, allowing for graceful failure handling.
     *
     * Note: As this is a private method, it is intended for internal use within the class.
     *
     * @param string $artistName The name of the artist for whom similar artists are to be retrieved.
     * @return mixed An array containing the details of similar artists to the specified artist or null if the request fails.
     */
    private static function getSimilarArtists($artistName)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.getsimilar',
            'artist' => $artistName,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? ResponseController::formatResponse('similar-artists', $response->json('similarartists.artist')) : null;
    }

}
