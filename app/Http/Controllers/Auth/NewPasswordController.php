<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @param Request $request The incoming request containing email and token.
     * @return Response The password reset page rendered by Inertia.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]); // Render the password reset view with email and token
    }

    /**
     * Handle an incoming new password request.
     *
     * @param Request $request The incoming request containing password reset data.
     * @return RedirectResponse Redirects to the login route with status message on successful reset,
     *                          or throws a ValidationException with error message on failure.
     * @throws \Illuminate\Validation\ValidationException Thrown if the password reset process encounters an error.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request for required fields
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Attempt to reset the user's password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                // Update the user's password and remember_token in the database
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                // Fire the PasswordReset event
                event(new PasswordReset($user));
            }
        );

        // Redirect to login with status message if password reset was successful
        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        // Throw a validation exception with error message if password reset failed
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }
}
