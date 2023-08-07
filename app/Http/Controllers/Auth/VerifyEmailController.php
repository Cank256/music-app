<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param EmailVerificationRequest $request The incoming request for email verification.
     * @return RedirectResponse Redirects to the intended route or home page with verification status.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Check if the user has already verified their email
        if ($request->user()->hasVerifiedEmail()) {
            // Redirect with verified flag if already verified
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        // Mark the email as verified and fire a Verified event if the marking is successful
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Redirect with verified flag after verification
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
