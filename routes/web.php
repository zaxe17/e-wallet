<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SignUpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::group(['prefix' => 'signup'], function () {
    Route::get('/', [SignupController::class, 'index'])->name('signup.form');
    Route::post('/', [SignupController::class, 'store'])->name('signup.store');
});

Route::group(['prefix' => 'login'], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login.form');
    Route::post('/', [LoginController::class, 'store'])->name('login.store');
});

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

Route::group(['prefix' => 'earnings'], function () {
    Route::get('/', [EarningsController::class, 'index'])->name('earnings.index');
    Route::post('/store', [EarningsController::class, 'store'])->name('earnings.store');
    Route::delete('/delete/{in_id}', [EarningsController::class, 'deleteEarnings'])->name('earnings.delete');
});

Route::group(['prefix' => 'expenses'], function () {
    Route::get('/', [ExpensesController::class, 'index'])->name('expenses.index');
    Route::post('/store', [ExpensesController::class, 'store'])->name('expenses.store');
    Route::delete('/delete/{out_id}', [ExpensesController::class, 'deleteExpenses'])->name('expenses.delete');
});

Route::group(['prefix' => 'savings'], function () {
    Route::get('/', [SavingsController::class, 'index'])->name('savings.index');
    Route::post('/store', [SavingsController::class, 'store'])->name('savings.store');
});

Route::group(['prefix' => 'settings'], function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/', [SettingsController::class, 'save'])->name('settings.save');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/validate-passkey', [SavingsController::class, 'validatePasskey']);
