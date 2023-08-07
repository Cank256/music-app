<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return Response The view for requesting a password reset link.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]); // Render the view for requesting a password reset link.
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param Request $request The incoming request containing the email address to send the reset link to.
     * @return RedirectResponse Redirects back with a success status if the reset link is sent, or with an error message if there's an issue.
     * @throws \Illuminate\Validation\ValidationException Thrown if the validation fails (e.g., email is missing or not valid).
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request to make sure the email field is provided and is a valid email address
        $request->validate([
            'email' => 'required|email',
        ]);

        // Attempt to send the password reset link to the provided email
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // If the reset link is successfully sent, redirect back with a success status
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // If there's an issue, throw a validation exception with the error message
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
