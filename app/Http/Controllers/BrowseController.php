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

        $topTags = $response->json('toptags.tag');

        return Inertia::render('Browse', [
            'topTags' => $topTags,
        ]);
    }

    public function getTag()
    {
        $info = Http::get(env('LASTFM_HOST')."?method=tag.getInfo&tag=".request()->query('tag')."&api_key=".env('LASTFM_API_KEY')."&format=json");
        $tagInfo = $info->json('tag');

        $artists = Http::get(env('LASTFM_HOST')."?method=tag.gettopartists&tag=".request()->query('tag')."&api_key=".env('LASTFM_API_KEY')."&limit=10&format=json");
        $topArtists = $artists->json('topartists.artist');

        $albums = Http::get(env('LASTFM_HOST')."?method=tag.gettopalbums&tag=".request()->query('tag')."&api_key=".env('LASTFM_API_KEY')."&limit=10&format=json");
        $topAlbums = $albums->json('albums.album');

        return Inertia::render('Tag', [
            'tag' => $tagInfo,
            'artists' => $topArtists,
            'albums' => $topAlbums,
        ]);
    }
}
