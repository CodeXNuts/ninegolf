<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserStripeAccountController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->prefix('user')->name('user.')->group(function () {

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserProfileController::class, 'index'])->name('view');
        Route::put('/{user}/update', [UserProfileController::class, 'update'])->name('update');
    });

    Route::prefix('clubs')->name('club.')->group(function () {

        Route::get('/create', [ProductController::class, 'getCreateClubView'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');

        Route::prefix('review')->name('review.')->group(function () {

            Route::post('/{club:slug}', [ClubRatingController::class, 'create'])->name('create');

            Route::prefix('reply')->name('reply.')->group(function () {
                Route::post('/{club:slug}/{clubRating}', [ClubRatingReplyController::class, 'create'])->name('create');
            });
        });
    });

    Route::prefix('paymentAcoount')->name('paymentAccount.')->group(function () {

        Route::post('/', [UserStripeAccountController::class, 'create'])->name('create');
        Route::post('/{userStripeConnectedAccount}/update', [UserStripeAccountController::class, 'update'])->name('update');
        Route::post('/{userStripeConnectedAccount}/sync', [UserStripeAccountController::class, 'syncAc'])->name('sync');
    });

    Route::prefix('order')->name('order.')->group(function () {
        Route::post('/', [OrderController::class, 'create'])->name('create');
        Route::post('/auth', [OrderController::class, 'checkAuth'])->name('checkAuth');
        Route::get('/{order}', [OrderController::class, 'view'])->name('view');
        Route::get('/{order}/pdf', [OrderController::class, 'generatePDF'])->name('invoice.download');
    });
});
