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
}
