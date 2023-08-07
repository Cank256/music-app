<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param Request $request The incoming request object containing user information.
     * @return RedirectResponse|Response Redirects to the intended route or home page if the user's email is verified,
     *                                   or renders the email verification prompt view if the email is not verified.
     */
    public function __invoke(Request $request): RedirectResponse|Response
    {
        // Check if the authenticated user has already verified their email
        return $request->user()->hasVerifiedEmail()
            // Redirect to intended route or home page if email is verified
            ? redirect()->intended(RouteServiceProvider::HOME)
            // Render the email verification prompt if email is not verified
            : Inertia::render('Auth/VerifyEmail', ['status' => session('status')]);
    }
}
