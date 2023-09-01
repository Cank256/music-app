<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class AlbumController extends Controller
{
    /**
     * Retrieves the top albums for a specified genre (R&B) from Last.fm's API.
     *
     * Utilizes the 'tag.gettopalbums' method from Last.fm's API, and expects the host and API key to be defined in the environment variables.
     * If the response is successful, the details of the top R&B albums are returned.
     * If the specified data is not found in the response, an empty array is returned.
     *
     * @return array An array containing the details of the top R&B albums or an empty array if not found.
     */
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

    /**
     * Retrieves detailed information about a specific album including similar albums, release date, and favorite status.
     *
     * The method initiates a GET request to Last.fm's API using the 'album.getinfo' method, passing the album and artist names obtained from the request query.
     * It then processes the response and extracts relevant album data, formats the response through ResponseController, and gets similar albums using a private method.
     * The release date is retrieved through web scraping using the WebScrapingController.
     * It also checks if the album is marked as a favorite by the authenticated user.
     * Finally, it renders the 'SingleAlbum' view, passing along all the retrieved information.
     *
     * @return \Inertia\Response An Inertia response containing the album details, similar albums, release date, and favorite status.
     */
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
        $album = ResponseController::formatResponse('album', $response->json('album'))->getData();
        $similarAlbums = $this->getSimilarAlbums($album->tags ? $album->tags[0] : '');
        $releaseDate = $album->url ? WebScrapingController::getReleaseDate($album->url) : '';
        $favorite = Favorite::where('user_id', auth()->id())
                            ->where('artist_name', $album->artist)
                            ->where('album_name', $album->name)
                            ->exists();

        return Inertia::render('SingleAlbum', [
            'album' => $album,
            'similarAlbums' => $similarAlbums,
            'releaseDate' => $releaseDate,
            'isFavorite' => $favorite ? true : false
        ]);
    }

    /**
     * Retrieves the top albums for a specific artist from Last.fm's API.
     *
     * Makes a GET request to Last.fm using the 'artist.gettopalbums' method, passing the artist name and limiting the result to 10 albums.
     * If the request is successful, the response is formatted using the ResponseController and the top albums are returned.
     * If the request fails, null is returned.
     *
     * @param string $artistName The name of the artist for whom the top albums are to be retrieved.
     * @return mixed The top albums for the specified artist or null if the request fails.
     */
    public static function getArtistTopAlbums($artistName)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'artist.gettopalbums',
            'artist' => $artistName,
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? ResponseController::formatResponse('artist-top-albums', $response->json('topalbums.album')) : null;
    }

    /**
     * Retrieves the top albums for a specific tag (genre) from Last.fm's API, usually used to get albums similar to a specified one.
     *
     * Makes a GET request to Last.fm using the 'tag.gettopalbums' method, passing the tag and limiting the result to 10 albums.
     * If the request is successful, the response is formatted using the ResponseController, and the similar albums are returned.
     * If the request fails, null is returned.
     *
     * @param object $tag The tag (genre) for which the top albums are to be retrieved.
     * @return mixed The top albums for the specified tag or null if the request fails.
     */
    public function getSimilarAlbums($tag)
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'tag.gettopalbums',
            'tag' => $tag->name ?? '',
            'api_key' => env('LASTFM_API_KEY'),
            'limit' => 10,
            'format' => 'json',
        ]);

        return $response->successful() ? ResponseController::formatResponse('similar-albums', $response->json('albums.album')) : null;
    }

}
