<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function index()
    {
        // get the logged-in user's favorites
        // return Favorite::where('user_id', auth()->id())->get();

        $albums = Favorite::where('user_id', auth()->id())
                            ->where('type', 'album')
                            ->get();

        $artists = Favorite::where('user_id', auth()->id())
                            ->where('type', 'artist')
                            ->get();

        return Inertia::render('Library', [
            'favoriteAlbums' => $albums,
            'favoriteArtists' => $artists,
        ]);
    }

    public function add(Request $request)
    {
        Log::info('User ID: ' . auth()->id());
    \Log::info('Type: ' . $request->get('type'));
    \Log::info('Artist: ' . $request->get('artist'));
    \Log::info('Album: ' . $request->get('album'));
    \Log::info('MBID: ' . $request->get('mbid'));
    \Log::info('Image: ' . $request->get('image'));
    \Log::info('Listeners: ' . $request->get('listeners'));

            Favorite::create([
                'user_id' => auth()->id(),
                'type' => $request->get('type'),
                'artist_name' => $request->get('artist'),
                'album_name' => $request->get('album') ? $request->get('album') : null,
                'mbid' => $request->get('mbid') ? $request->get('mbid') : null,
                'image' => $request->get('image') ? $request->get('image') : null,
                'listeners' => $request->get('listeners') ? $request->get('listeners') : null,
            ]);

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $favorite = Favorite::where('user_id', auth()->id())
                        ->where('type', $request->get('type'))
                        ->where('artist_name', $request->get('artist'))
                        ->where('album_name', $request->get('album'))
                        ->where('mbid', $request->get('mbid'))
                        ->first();

        $favorite->delete();

        return redirect()->back();

    }
}
