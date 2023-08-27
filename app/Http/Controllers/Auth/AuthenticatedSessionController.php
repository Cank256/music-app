<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return Response The login page rendered by Inertia.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),  // Check if password reset route is available
            'status' => session('status'),                         // Get the current session status
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request The incoming login request.
     * @return RedirectResponse Redirects to the intended route or home page after successful authentication.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();          // Authenticate the user

        $request->session()->regenerate(); // Regenerate the session to prevent session fixation attacks

        return redirect()->intended(RouteServiceProvider::HOME); // Redirect to intended route or home page
    }

    /**
     * Destroy an authenticated session.
     *
     * @param Request $request The incoming request.
     * @return RedirectResponse Redirects to the homepage after logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();           // Logout the authenticated user

        $request->session()->invalidate();      // Invalidate the current session

        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/');                   // Redirect to the homepage
    }

    /**
     * Redirect the user to Google for authentication.
     *
     * @return mixed Redirects the user to Google's authentication page.
     */
    public function signInwithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google authentication callback.
     *
     * @return RedirectResponse Redirects to the dashboard after successful authentication or creation of a new user.
     */
    public function googleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();          // Get user details from Google

            $finduser = User::where('gauth_id', $user->id)->first(); // Check if the user already exists in the database

            if($finduser){
                Auth::login($finduser);                            // Login the existing user
                return redirect()->intended(RouteServiceProvider::HOME);
            } else {
                // Create a new user from the details fetched from Google
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'gauth_id'=> $user->id,
                    'gauth_type'=> 'google',
                    'password' => encrypt('admin@123')   // Use a default password (not recommended for production!)
                ]);

                // Fire a registered event for the newly created user
                event(new Registered($newUser));

                // Log the user in
                Auth::login($newUser);

                // Redirect to the home page
                return redirect(RouteServiceProvider::HOME);
            }
        } catch (Exception $e) {
            // Dump and die in case of an error (may need to remove it as it is not recommended for production!)
            dd($e);
        }
    }
}
