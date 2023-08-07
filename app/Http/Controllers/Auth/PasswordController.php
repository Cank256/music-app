<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     *
     * @param Request $request The incoming request containing the current and new password.
     * @return RedirectResponse Redirects back to the previous page after successful password update.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validate the incoming request for required fields, current password correctness, and new password confirmation
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Update the user's password in the database with the newly validated password
        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back(); // Redirect back to the previous page
    }
}
