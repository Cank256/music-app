<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    public function index()
    {

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
