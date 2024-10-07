<?php

use App\DTOs\RegisterDTO;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsSubscribe;
use App\Http\Middleware\IsSubscribeForCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)
    ->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

Route::controller(SubscribeController::class)
    ->prefix('subscribe')
    ->middleware(['auth:sanctum'])
    ->group(function() {
        Route::post('/', 'addSubscribe')
            ->middleware([IsSubscribe::class, IsSubscribeForCommand::class]);
        Route::post('/change-renewal', 'changeSubscribeRenewal')
            ->middleware([IsSubscribe::class, IsSubscribeForCommand::class]);
        Route::put('/change-subscribe', 'changeSubscribe');
        Route::post('/payment-subscribe', 'addSubscribe');
    });

Route::controller(UserController::class)
    ->prefix('user')
    ->group(function () {
        Route::get('/', 'getUserWithOrderAndSubscribe');
    });
