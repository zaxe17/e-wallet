<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

// FOR SIGNIN FUNCTIONS
Route::group(['prefix' => 'signup'], function() {
    Route::resource('/', SignUpController::class)->names(['index' => 'signupForm']);
});

// FOR LOGIN FUNCTIONS
Route::group(['prefix' => 'login'], function() {
    Route::resource('/', LoginController::class)->names(['index' => 'loginForm']);
});

Route::group(['prefix' => 'dashboard'], function() {
    Route::resource('/', DashboardController::class)->names(['index' => 'dashboard']);
});
