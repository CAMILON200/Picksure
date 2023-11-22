<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
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

Route::get('/payment/{key}', function ($key) {
	return view('payment', ['key' => $key]);
});

Route::get('/responsepay/{key}', function ($key) {
	return view('responsepay', ['key' => $key]);
});

Route::get('/resetpassword/{key}/{lang}', function ($key, $lang) {
	return view('resetpassword', ['key' => $key, 'lang' => $lang]);
});

Route::get('/phpinfo', function() {
	return phpinfo();
});

Route::group(['prefix' => 'admin'], function () {
	Voyager::routes();
});