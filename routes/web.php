<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Tipoff\Authorization\Http\Controllers\AuthController;

Route::middleware(config('tipoff.web.middleware_group'))
    ->prefix(config('tipoff.web.uri_prefix'))
    ->group(function () {

        // NO AUTH/GUEST ONLY
        Route::middleware('guest:email,web')->group(function () {
            Route::get('cart/create', function () {
                return view('authorization::create');
            })->name('authorization.email-login');

            Route::post('cart/create', [AuthController::class, 'emailLogin']);
        });
    });
