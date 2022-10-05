<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WishListController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/about',function(){
    return view('about');
});

Route::get('/how-it-works',function(){
    return view('how-it-work');
});

Route::get('/rent-clubs',function(){
    return view('rentalclubs');
});
Route::get('/contact',function(){
    return view('contact');
});

Route::get('/rent-details',function(){
    return view('rental-details');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/product/{club:slug}',[ProductController::class,'view'])->name('product.view');
Route::post('/wishlist/manage',[WishListController::class,'manageWislistCRUD'])->name('wishlist.manage');
Route::post('/getClubPrice/{club}',[ProductController::class,'clubPrice'])->name('product.getprice');


Route::prefix('cart')->name('cart.')->group(function(){
    Route::get('/',[CartController::class,'index'])->name('view');
    Route::post('/add',[CartController::class,'store'])->name('add');
    Route::get('/count',[CartController::class,'getCartCount'])->name('getcount');
    Route::delete('/cartItem/{cartItem}/delete',[CartController::class,'destroy'])->name('cartItem.remove');


});

Route::get('/search',[SearchController::class,'index'])->name('search');


