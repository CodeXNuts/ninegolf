<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ClubRatingController;
use App\Http\Controllers\ClubRatingReplyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserStripeAccountController;
use App\Models\UserStripeConnectedAccount;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::get('profile',[AuthenticatedSessionController::class,'view'])->name('profile');
    Route::put('profile/{user}/update',[AuthenticatedSessionController::class,'update'])->name('profile.update');
    Route::get('/list-my-club',[ProductController::class,'getCreateClubView'])->name('product.create');
    Route::post('/list-my-club',[ProductController::class,'create'])->name('product.create');
    Route::post('/profile/payments',[UserStripeAccountController::class,'create'])->name('payment.account.create');
    Route::post('/profile/payments/{userStripeConnectedAccount}/update',[UserStripeAccountController::class,'update'])->name('payment.account.update');
    Route::post('/profile/payments/{userStripeConnectedAccount}/sync',[UserStripeAccountController::class,'syncAc'])->name('payment.account.sync');
    Route::post('/order',[OrderController::class,'create'])->name('order.create');
    Route::post('/order/auth',[OrderController::class,'checkAuth'])->name('order.checkAuth');
    Route::get('/order/{order}',[OrderController::class,'view'])->name('order.view');
    Route::get('/order/{order}/pdf',[OrderController::class,'generatePDF'])->name('pdf.download');
    Route::post('/product/{club:slug}/review',[ClubRatingController::class,'create'])->name('product.review.create');
    Route::post('/product/{club:slug}/review/{clubRating}/reply',[ClubRatingReplyController::class,'create'])->name('product.review.reply.create');

    
});
