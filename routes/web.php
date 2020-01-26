<?php

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

Route::get('/', 'HomeController@list')->name('home');

Auth::routes();

Route::post('/subscribe', 'SubscribeController@subscribe');

//Stripe
Route::get('subscribe', 'SubscribeController@payment')->name('subscribe');
Route::post('/unsubscribe','SubscribeController@destroy');
Route::post('/cancel','SubscribeController@cancel');

Route::resource('projets', 'ProjetController');
