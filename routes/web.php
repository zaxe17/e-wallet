<?php

use App\Http\Controllers\SigninController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('component.home');
});

Route::get('/signin', [SigninController::class, 'signin'])->name('signinForm');