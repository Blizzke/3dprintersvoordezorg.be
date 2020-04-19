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

Route::get('/helper/register', 'HelperController@registrationForm')->name('register');
Route::post('/helper/register', 'HelperController@register');
Route::get('/helper/login', 'HelperController@loginForm')->name('login');
Route::post('/helper/login', 'HelperController@login');
Route::get('/helper/dashboard', 'HelperController@dashboard');
