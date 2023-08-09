<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class BrowseController extends Controller
{
    /**
     * Retrieves and renders the top music tags (genres) from Last.fm's API for browsing.
     *
     * The method initiates a GET request to Last.fm using the 'tag.getTopTags' method, expecting the host and API key to be defined in the environment variables.
     * The response is then formatted using the ResponseController, and the top tags are extracted.
     * The method finally renders the 'Browse' view, passing the top tags as data, allowing users to browse various music genres.
     *
     * @return \Inertia\Response An Inertia response containing the top tags (genres) to be displayed in the 'Browse' view.
     */
    public function index()
    {
        $response = Http::get(env('LASTFM_HOST'), [
            'method' => 'tag.getTopTags',
            'api_key' => env('LASTFM_API_KEY'),
            'format' => 'json',
        ]);

        $topTags = ResponseController::formatResponse('tags', $response->json('toptags.tag'));

        return Inertia::render('Browse', [
            'topTags' => $topTags,
        ]);
    }

    /**
     * Retrieves and renders detailed information about a specific music tag (genre) from Last.fm's API, including top artists and albums.
     *
     * The method makes three separate GET requests to Last.fm:
     * 1. Fetching general information about the tag using the 'tag.getInfo' method.
     * 2. Retrieving the top artists for the tag using the 'tag.gettopartists' method, with a limit of 10 artists.
     * 3. Obtaining the top albums for the tag using the 'tag.gettopalbums' method, with a limit of 10 albums.
     *
     * Each response is formatted using the ResponseController, and the resulting information is combined to render the 'Tag' view,
     * providing an insightful display of the specified tag's information, top artists, and top albums.
     *
     * @return \Inertia\Response An Inertia response containing the details of the tag, top artists, and top albums to be displayed in the 'Tag' view.
     */
    public function getTag()
    {
        $info = Http::get(env('LASTFM_HOST')."?method=tag.getInfo&tag=".request()->query('tag')."&api_key=".env('LASTFM_API_KEY')."&format=json");
        $tagInfo = ResponseController::formatResponse('tag', $info->json('tag'))->getData();

        $artists = Http::get(env('LASTFM_HOST')."?method=tag.gettopartists&tag=".request()->query('tag')."&api_key=".env('LASTFM_API_KEY')."&limit=10&format=json");
        $topArtists = ResponseController::formatResponse('tag-top-artists', $artists->json('topartists.artist'));

        $albums = Http::get(env('LASTFM_HOST')."?method=tag.gettopalbums&tag=".request()->query('tag')."&api_key=".env('LASTFM_API_KEY')."&limit=10&format=json");
        $topAlbums = ResponseController::formatResponse('tag-top-albums', $albums->json('albums.album'));

        // return $tagInfo;

        return Inertia::render('Tag', [
            'tag' => $tagInfo,
            'artists' => $topArtists,
            'albums' => $topAlbums,
        ]);
    }
}
