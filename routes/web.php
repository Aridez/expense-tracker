<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgottenPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Cookie\SessionCookieJar;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function () {
    //Route::singleton('accounts', AccountController::class)->creatable()->only(['create', 'store']);
    Route::get('/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/accounts', [AccountController::class, 'store'])->name('accounts.store');

    //Route:singleton('sessions', SessionController:class)->only(['create', 'store']);
    Route::get('sessions/create', [SessionController::class, 'create'])->name('sessions.create');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');

    //Route::singleton('forgotten-password', ForgottenPasswordController::class)->only(['create']);
    Route::get('/forgotten-password/create', [ForgottenPasswordController::class, 'create'])->name('forgotten-password.create');
    Route::post('/forgotten-password', [ForgottenPasswordController::class, 'store'])->name('forgotten-password.store');
    Route::get('/forgotten-password/edit', [ForgottenPasswordController::class, 'edit'])->name('forgotten-password.edit');
    Route::put('/forgotten-password', [ForgottenPasswordController::class, 'update'])->name('forgotten-password.update');

});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware('auth')->group(function () {
    //Route::singleton('accounts', AccountController::class)->only(['edit', 'update']);
    Route::get('/accounts/edit', [AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('/accounts', [AccountController::class, 'update'])->name('accounts.update');

    //Route::singleton('sessions', SessionController::class)->creatable()->only(['destroy']);
    Route::delete('/sessions', [SessionController::class, 'destroy'])->name('sessions.destroy');
});

//require __DIR__ . '/auth.php';
