<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return Response The registration page rendered by Inertia.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register'); // Render the registration view
    }

    /**
     * Handle an incoming registration request.
     *
     * @param Request $request The incoming request containing registration information.
     * @return RedirectResponse Redirects to the home page after successful registration and login.
     * @throws \Illuminate\Validation\ValidationException Thrown if validation fails.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the registration request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create the user using the validated data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Fire a registered event for the newly created user
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        // Redirect to the home page
        return redirect(RouteServiceProvider::HOME);
    }
}
