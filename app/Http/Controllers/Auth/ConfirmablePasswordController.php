<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return Response The confirm password page rendered by Inertia.
     */
    public function show(): Response
    {
        // Render the password confirmation view
        return Inertia::render('Auth/ConfirmPassword');
    }

    /**
     * Confirm the user's password.
     *
     * @param Request $request The incoming request containing the password.
     * @return RedirectResponse Redirects to the intended route or home page after successful password confirmation.
     * @throws ValidationException Thrown if the password does not match the authenticated user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the provided password against the authenticated user's password
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                // Throw a validation exception if the password is incorrect
                'password' => __('auth.password'),
            ]);
        }

        // Store the timestamp of the password confirmation in the session
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect to intended route or home page
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
