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

// Administrateur
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', 'Admin\DashboardController@data');
    Route::get('/user-register', 'Admin\DashboardController@registered');
    Route::get('/projet-register', 'Admin\DashboardController@posted');
    Route::get('/user-edit/{id}', 'Admin\DashboardController@registeredit');
    Route::put('/user-register-update/{id}', 'Admin\DashboardController@registerupdate');
    Route::get('/projet-edit/{id}', 'Admin\DashboardController@projetedit');
    Route::put('/projet-register-update/{id}', 'Admin\DashboardController@projetupdate');
    Route::delete('/user-delete/{id}', 'Admin\DashboardController@registerdelete' );
    Route::delete('/projet-delete/{id}', 'Admin\DashboardController@projetdelete');
    Route::get('/projet-by-user/{id}', 'Admin\DashboardController@projetbyuser');
});
