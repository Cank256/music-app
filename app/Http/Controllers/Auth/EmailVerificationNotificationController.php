<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param Request $request The incoming request object, containing user information.
     * @return RedirectResponse If the user has already verified their email, redirect to the intended route or home page.
     *                          Otherwise, send a new verification link and redirect back with a status message.
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if the authenticated user has already verified their email
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect to intended route or home page if email is verified
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Send a new email verification notification
        $request->user()->sendEmailVerificationNotification();

        // Redirect back with a status message indicating that the verification link was sent
        return back()->with('status', 'verification-link-sent');
    }
}
