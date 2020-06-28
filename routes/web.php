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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home/edit/contacts', 'ContactsController@index')->name('home.contacts');
Route::patch('/home/contacts/{contacts}', 'ContactsController@update')->name('contacts.update');

Route::resource('seller', 'SellerController');

Route::get('/shop', 'ShopController@index')->name('shop.index');
Route::get('/shop/{shop}', 'ShopController@show')->name('shop.show');

Route::get('/basket', 'BasketController@index')->name('basket.index');
Route::get('/basket/{basket}', 'BasketController@show')->name('basket.show');
Route::post('/basket', 'BasketController@store')->name('basket.store');

Route::post('/order/make', 'OrderController@make')->name('order.make');
Route::post('/order', 'OrderController@store')->name('order.store');

Route::get('/customer/orders', 'CustomerController@index')->name('customer.orders');
