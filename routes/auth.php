<?php


use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::domain('landlord.myapp.test')->group(function () {
    Route::middleware('guest:web')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('landlord.register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('landlord.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    Route::middleware('auth:web')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('landlord.logout');
    });
});
