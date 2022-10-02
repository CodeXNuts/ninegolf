<?php

use App\Http\Controllers\Administrator\ProductController as AdministratorProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\WishListController;
use App\Models\UserStripeConnectedAccount;
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
    return view('index');
})->name('home');

Route::get('/about',function(){
    return view('about');
});

Route::get('/product/{club:slug}',[ProductController::class,'view'])->name('product.view');

Route::post('/wishlist/manage',[WishListController::class,'manageWislistCRUD'])->name('wishlist.manage');
Route::post('/getClubPrice/{club}',[ProductController::class,'clubPrice'])->name('product.getprice');
Route::get('/cart',[CartController::class,'index'])->name('cart');
Route::post('/cart/add',[CartController::class,'store'])->name('cart.add');
Route::get('/cart/count',[CartController::class,'getCartCount'])->name('cart.getcount');
Route::delete('/cartItem/{cartItem}/delete',[CartController::class,'destroy'])->name('cartItem.remove');



Route::get('/test',[TestController::class,'index']);


Route::get('/how-it-works',function(){
    return view('how-it-work');
});

Route::get('/rent-clubs',function(){
    return view('rentalclubs');
});
Route::get('/contact',function(){
    return view('contact');
});
// Route::get('/individual-club',function(){
//     return view('product.show.index');
// });

Route::get('/rent-details',function(){
    return view('rental-details');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route::get('/test',function(){
//     return view('invoice.order-invoice');
// });

require __DIR__.'/auth.php';
require __DIR__.'/administrator.php';