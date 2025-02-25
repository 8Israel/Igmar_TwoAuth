<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoFactorAuthentication;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;
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

Route::get('/', function () {
    return view('pages.home');
})->name('home')->middleware(['auth','2FA','verified']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit')->middleware();
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/verify-2fa', [TwoFactorAuthentication::class, 'showVerifyForm'])->name('2fa.form')->middleware(['auth','guest', 'verified']);
Route::post('/verify-2fa', [TwoFactorAuthentication::class, 'verify'])->name('2fa.verify');


/* Validación a rutas inexistentes */
Route::fallback(function () {
    return redirect()->route('home');
});

// Verificación de correo (rutas firmadas)
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Vista para pedir al usuario que verifique su correo
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marca el correo como verificado
    return redirect('/'); // Redirige tras verificar
})->middleware(['auth', 'signed'])->name('verification.verify');

// Reenviar el correo de verificación
Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');