<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

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

Route::resource('items', '\App\Http\Controllers\ItemController')->middleware('auth');
Route::resource('categories', '\App\Http\Controllers\CategoryController')->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/productlist' ,[App\Http\Controllers\ItemController::class, 'productlist'])->name('productlist');

Route::get('/product/{id}', [App\Http\Controllers\ItemController::class, 'productdetails'])->name('product.details');

Route::get('/cart', [App\Http\Controllers\ItemController::class, 'shoppingcart'])->name('Cart');

Route::post('/cart', [App\Http\Controllers\CartController::class, 'update_cart'])->name('update_cart');













