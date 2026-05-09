<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/drivers', function () {
    return view('drivers');
});

Route::get('/parking-garage-owners', function () {
    return view('parking-garage-owners');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:web,parking_garage_owner', 'verified'])->name('dashboard');

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

// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth:parking_garage_owner', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
