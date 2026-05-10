<?php

use App\Http\Controllers\ParkingGarageOwnerAuthenticatedSessionController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ParkingGarageOwnerRegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    
    Route::get('parking-garage-owners-register', [ParkingGarageOwnerRegisteredUserController::class, 'create'])
        ->name('parking-garage-owners-register');

    Route::post('parking-garage-owners-register', [ParkingGarageOwnerRegisteredUserController::class, 'store']);

    Route::get('parking-garage-owners-login', [ParkingGarageOwnerAuthenticatedSessionController::class, 'create'])
        ->name('parking-garage-owners-login');

    Route::post('parking-garage-owners-login', [ParkingGarageOwnerAuthenticatedSessionController::class, 'store']);




    Route::get('drivers-register', [RegisteredUserController::class, 'create'])
        ->name('drivers-register');

    Route::post('drivers-register', [RegisteredUserController::class, 'store']);

    Route::get('drivers-login', [AuthenticatedSessionController::class, 'create'])
        ->name('drivers-login');

    Route::post('drivers-login', [AuthenticatedSessionController::class, 'store']);






    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    // Route::get('parking-garage-owners-register', [ParkingGarageOwnerRegisteredUserController::class, 'create'])
    //     ->name('parking-garage-owners-register');

    // Route::post('parking-garage-owners-register', [ParkingGarageOwnerRegisteredUserController::class, 'store']);

    // Route::get('parking-garage-owners-login', [ParkingGarageOwnerAuthenticatedSessionController::class, 'create'])
    //     ->name('parking-garage-owners-login');

    // Route::post('parking-garage-owners-login', [ParkingGarageOwnerAuthenticatedSessionController::class, 'store']);




    // Route::get('drivers-register', [RegisteredUserController::class, 'create'])
    //     ->name('drivers-register');

    // Route::post('drivers-register', [RegisteredUserController::class, 'store']);

    // Route::get('drivers-login', [AuthenticatedSessionController::class, 'create'])
    //     ->name('drivers-login');

    // Route::post('drivers-login', [AuthenticatedSessionController::class, 'store']);

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    //The 'destroy' method of the AuthenticatedSessionController::class was specifically modified
    //to apply to both of the seperate user groups 'users' and 'parking_garage_owners'
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
