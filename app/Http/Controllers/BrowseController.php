<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class BrowseController extends Controller
{
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
