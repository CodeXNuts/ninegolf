<?php

use App\Http\Controllers\Administrator\AdminController;
use App\Http\Controllers\Administrator\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Administrator\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Administrator\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Administrator\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Administrator\Auth\NewPasswordController;
use App\Http\Controllers\Administrator\Auth\PasswordResetLinkController;
use App\Http\Controllers\Administrator\Auth\RegisteredUserController;
use App\Http\Controllers\Administrator\Auth\VerifyEmailController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\ProductController;
use App\Http\Controllers\Administrator\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('administrator')->name('administrator.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->middleware('auth:administrator');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('auth:administrator')
        ->name('dashboard');

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->middleware('guest:administrator')
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest:administrator');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest:administrator')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest:administrator');

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->middleware('guest:administrator')
        ->name('password.request');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest:administrator')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->middleware('guest:administrator')
        ->name('password.reset');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest:administrator')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth:administrator')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth:administrator', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:administrator', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth:administrator')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth:administrator');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:administrator')
        ->name('logout');

    Route::get('/users',[UserController::class ,'index'])->name('user');
    Route::get('/clubs',[ProductController::class ,'index'])->name('club');
    Route::put('/product/{club:slug}/approve',[ProductController::class,'approve']) ->middleware('auth:administrator')->name('product.approve');
    Route::put('/product/{club:slug}/suspend',[ProductController::class,'suspend']) ->middleware('auth:administrator')->name('product.suspend');
    Route::get('/profile',[AdminController::class,'index'])->name('profile');
    Route::put('/profile/{administrator}',[AdminController::class,'update'])->name('profile.update');
});
