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

//Offers
Route::get('/offer/{id}', 'OfferController@create')->name('offers.create');
Route::post('/offer/', 'OfferController@store')->name('offers.store');

//Profil
Route::get('/profil/{id}', 'UserController@show')->name('profil');
Route::get('/profil/edit/{id}', 'UserController@edit')->name('profil-edit');
Route::post('/profil/edit/{id}', 'UserController@update')->name('profil-update');

Route::get('/projet/download/{id}', 'ProjetController@download')->name('downloadfile');

//Upload avatar
Route::post('image-upload', 'UserController@imageUpload')->name('image.upload');

//Sentry
// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error!');
// });
