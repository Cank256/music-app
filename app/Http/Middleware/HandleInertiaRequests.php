<?php

namespace App\Http\Middleware;

use App\Models\Favorite;
use Auth;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'favorites' => function () {
                // check if user is authenticated
                if (Auth::user()) {
                    // Get the favorites records for this user
                    return [
                        'artists' => Favorite::where('user_id', Auth::user()->id)
                                            ->where('type', 'artist')
                                            ->get(),
                        'albums' => Favorite::where('user_id', Auth::user()->id)
                                            ->where('type', 'album')
                                            ->get(),
                    ];
                }

                return null;
            },
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
