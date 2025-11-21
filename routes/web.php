<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::group(['prefix' => 'signup'], function() {
    Route::get('/', [SignupController::class, 'index'])->name('signup.form');
    Route::post('/', [SignupController::class, 'store'])->name('signup.store');
});

Route::group(['prefix' => 'login'], function() {
    Route::get('/', [LoginController::class, 'index'])->name('login.form');
});

Route::group(['prefix' => 'dashboard'], function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group(['prefix' => 'earnings'], function() {
    Route::get('/', [EarningsController::class, 'index'])->name('earnings.index');
});

Route::group(['prefix' => 'expenses'], function() {
    Route::get('/', [ExpensesController::class, 'index'])->name('expenses.index');
});

Route::group(['prefix' => 'savings'], function() {
    Route::get('/', [SavingsController::class, 'index'])->name('savings.index');
});