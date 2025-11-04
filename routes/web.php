<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('component.home');
});

// FOR SIGNIN FUNCTIONS
Route::group(['prefix' => 'signup'], function() {
    Route::get('/', [SignUpController::class, 'signup'])->name('signupForm');
});

Route::group(['prefix' => 'login'], function() {
    Route::get('/', [LoginController::class, 'login'])->name('loginForm');
});
