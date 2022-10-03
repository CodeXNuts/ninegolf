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

require __DIR__.'/common.php';
require __DIR__.'/auth.php';
require __DIR__.'/user.php';
require __DIR__.'/administrator.php';