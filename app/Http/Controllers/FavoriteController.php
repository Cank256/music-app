<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FavoriteController extends Controller
{
    /**
     * Renders the user's library, displaying their favorite albums and artists.
     *
     * Retrieves the favorite albums and artists associated with the authenticated user from the Favorite model.
     * Renders the 'Library' view, passing the favorite albums and artists for display.
     *
     * @return \Inertia\Response An Inertia response containing the favorite albums and artists to be displayed in the 'Library' view.
     */
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

    /**
     * Adds a new favorite artist or album for the authenticated user.
     *
     * Receives the details of the favorite item (artist or album) via the request object and creates a new record in the Favorite model.
     * Redirects back to the previous page once the item is successfully added to the favorites.
     *
     * @param \Illuminate\Http\Request $request The request object containing the details of the favorite item to be added.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the previous page.
     */
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

    /**
     * Removes a favorite artist or album for the authenticated user.
     *
     * Identifies the favorite item (artist or album) via the request object and deletes the corresponding record from the Favorite model.
     * Redirects back to the previous page once the item is successfully removed from the favorites.
     *
     * @param \Illuminate\Http\Request $request The request object containing the details of the favorite item to be removed.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the previous page.
     */
    public function remove(Request $request)
    {
        $favorite = Favorite::where('user_id', auth()->id())
                        ->where('type', $request->get('type'))
                        ->where('artist_name', $request->get('artist'))
                        ->where('album_name', $request->get('album'))
                        ->where('mbid', $request->get('mbid'))
                        ->first();

        if ($favorite) {
            $favorite->delete();
        }

        return redirect()->back();

    }
}
