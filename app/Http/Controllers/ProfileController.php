<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Favorite;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Renders the profile page with favorite albums and artists for the authenticated user.
     *
     * Retrieves favorite albums and artists associated with the authenticated user.
     * Returns an Inertia response to render the 'Profile/Profile' view, displaying user information, verification status, and favorite items.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @return \Inertia\Response An Inertia response containing the user's profile details.
     */
    public function index(Request $request): Response
    {
        $favoriteAlbums = Favorite::where('user_id', auth()->id())
                                    ->where('type', 'album')
                                    ->get();
        $favoriteArtists = Favorite::where('user_id', auth()->id())
                                    ->where('type', 'artist')
                                    ->get();

        return Inertia::render('Profile/Profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'favoriteAlbums' => $favoriteAlbums,
            'favoriteArtists' => $favoriteArtists,
        ]);
    }

    /**
     * Renders the profile edit page for the authenticated user.
     *
     * Returns an Inertia response to render the 'Profile/Edit' view, where the user can update their profile information.
     * The response includes information about email verification status and any status messages from the session.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @return \Inertia\Response An Inertia response containing the user's profile edit details.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Updates the user's profile information based on the provided validated request data.
     *
     * If the email is updated, it also sets the email_verified_at field to null.
     * Redirects to the profile edit page after successfully updating the user's profile.
     *
     * @param \App\Http\Requests\ProfileUpdateRequest $request A validated request containing the updated profile information.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the profile edit page.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Deletes the user's account after validating the provided password.
     *
     * Logs the user out, deletes the user's record, invalidates the session, and regenerates the session token.
     * Redirects to the application's root URL after successfully deleting the account.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the password to be validated.
     * @return \Illuminate\Http\RedirectResponse A redirect response to the root URL.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
