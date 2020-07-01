<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'Me\HomeController@index')->name('home');

Route::get('/customer/edit/contacts', 'Me\ContactsController@index')->name('customer.contacts');
Route::patch('/customer/contacts/{contacts}', 'Me\ContactsController@update')->name('contacts.update');

Route::post('/order/make', 'Shop\OrderController@make')->name('order.make');
Route::post('/order/update', 'Shop\OrderController@changeStatus')->name('order.update');
Route::post('/order', 'Shop\OrderController@store')->name('order.store');
Route::get('/customer/orders', 'Shop\OrderController@ordersForCustomer')->name('customer.orders');

Route::get('/seller/orders', 'Shop\OrderController@ordersForSeller')->name('seller.orders');
Route::resource('seller', 'Me\SellerController');

Route::get('/shop', 'Shop\ShopController@index')->name('shop.index');
Route::get('/shop/{shop}', 'Shop\ShopController@show')->name('shop.show');
Route::get('/shop/{shop}/product/{product}', 'Shop\ShopController@singleProduct')->name('shop.single');

Route::get('/basket', 'Shop\BasketController@index')->name('basket.index');
Route::post('/basket', 'Shop\BasketController@store')->name('basket.store');
