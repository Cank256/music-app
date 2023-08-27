<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

// GUEST MIDDLEWARE ROUTES
// Handles routes available to unauthenticated users (guests)
Route::middleware('guest')->group(function () {

    // SIGNUP ROUTES
    // Displays the registration form and handles registration
    Route::get('signup', [RegisteredUserController::class, 'create'])->name('signup');
    Route::post('signup', [RegisteredUserController::class, 'store']);

    // LOGIN ROUTES
    // Displays the login form and handles authentication
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // FORGOT PASSWORD ROUTES
    // Handles forgotten password requests and email notifications
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // RESET PASSWORD ROUTES
    // Handles password reset functionality
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    // GOOGLE AUTHENTICATION ROUTES
    // Handles authentication via Google OAuth
    Route::get('auth/google', [AuthenticatedSessionController::class, 'signInwithGoogle'])->name('google.signin');
    Route::get('auth/google/callback', [AuthenticatedSessionController::class, 'googleCallback']);
});

// AUTH MIDDLEWARE ROUTES
// Handles routes available to authenticated users
Route::middleware('auth')->group(function () {

    // EMAIL VERIFICATION ROUTES
    // Handles email verification process
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    // CONFIRM PASSWORD ROUTES
    // Handles password confirmation for extra security
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // UPDATE PASSWORD ROUTE
    // Handles password updates
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    // LOGOUT ROUTE
    // Handles user logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
