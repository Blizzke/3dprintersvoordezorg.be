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

Route::get('/', 'HomeController@frontPage');

Route::get('/helper/register', 'HelperController@registrationForm')->name('register');
Route::post('/helper/register', 'HelperController@register');
Route::get('/helper/login', 'HelperController@loginForm')->name('login');
Route::post('/helper/login', 'HelperController@login');
Route::get('/helper/logout', 'HelperController@logout')->name('logout');
Route::get('/helper/dashboard', 'HelperController@dashboard')->name('dashboard');
Route::get('/helper/how-what-where', 'HelperController@howWhatWhere');
Route::post('/helper/how-what-where', 'HelperController@confirmHowWhatWhere');
Route::get('/helper/profile', 'HelperController@profileForm')->name('profile');
Route::post('/helper/profile', 'HelperController@updateProfile');
Route::get('/helper/locked', 'HelperController@locked');
Route::get('/helper/unlock/{helper}', 'HelperController@unlock');
Route::post('/helper/unlock/{helper}', 'HelperController@doUnlock');

Route::get('/helper/order/{order}/accept', 'OrderController@accept')->name('order-accept');
Route::get('/helper/order/{order}/release', 'OrderController@release')->name('order-release');
Route::get('/helper/order/{order}/cancel', 'OrderController@cancel')->name('order-cancel');
Route::post('/helper/order/{order}/work', 'OrderController@work')->name('order-work');
Route::get('/helper/order/{order}/help', 'OrderController@participate')->name('order-help');
Route::post('/helper/order/{order}/help', 'OrderController@doParticipate');

Route::get('/order/new', 'OrderController@newOrderView');
Route::post('/order/new', 'OrderController@newOrderForm');

Route::get('/order/{order}', 'OrderController@view')->name('order');
Route::get('/order/{order}/map', 'OrderController@viewMap');
Route::post('/order/{order}/comment', 'OrderController@addComment')->name('order-comment');
Route::get('/order/{order}/status', 'OrderController@updateStatus')->name('order-status');
Route::post('/order/{order}/status', 'OrderController@updateOptions')->name('order-options');
Route::post('/order/{order}/quantity', 'OrderController@addQuantity')->name('order-add-quantity');
Route::get('/customer/{customer}', 'OrderController@orderOverview')->name('customer');
Route::get('/customer/{customer}/order/{order}', 'OrderController@customerLogin')->name('order-customer');

