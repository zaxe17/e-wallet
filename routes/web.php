<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('component.home');
});

// FOR SIGNIN FUNCTIONS
Route::group(['prefix' => 'signup'], function() {
    Route::resource('/', SignUpController::class)->names(['index' => 'signupForm']);
});

Route::group(['prefix' => 'login'], function() {
    Route::resource('/', LoginController::class)->names(['index' => 'loginForm']);
});
