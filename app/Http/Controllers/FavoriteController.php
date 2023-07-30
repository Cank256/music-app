<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index()
    {
        // get the logged-in user's favorites
        return Favorite::where('user_id', auth()->id())->get();
    }

    public function add(Request $request)
    {
        $favorite = Favorite::where('user_id', auth()->id())
                        ->where('type', $request->get('type'))
                        ->where('artist_name', $request->get('artist'))
                        ->where('album_name', $request->get('album'))
                        ->first();

        if ($favorite)
        {
            // If the record exists, delete it
            $favorite->delete();
        }
        else {
            // If the record does not exist, create it
            $favorite = Favorite::create([
                'user_id' => auth()->id(),
                'type' => $request->get('type'),
                'artist_name' => $request->get('artist'),
                'album_name' => $request->get('album') ? $request->get('album') : null,
            ]);
        }

        return redirect()->back();
    }
}
