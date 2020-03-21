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

//Register
Auth::routes();
Route::get('/profil_choice', 'UserController@register_choice')->name('register_choice');
Route::get('/register/{role}', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register/{role}', 'Auth\RegisterController@register');

//Social Register
Route::get('social-login/{provider}', 'Auth\LoginController@redirectToProvider')->name('social-login.redirect');
Route::get('social-login/{provider}/callback/', 'Auth\LoginController@handleProviderCallback')->name('social-login.callback');

//Stripe
Route::post('/subscribe', 'SubscribeController@subscribe');
Route::get('subscribe', 'SubscribeController@payment')->name('subscribe');
Route::post('/unsubscribe','SubscribeController@destroy');
Route::post('/cancel','SubscribeController@cancel');

//Projet
Route::resource('projet', 'ProjetController');
Route::get('/projet/download/{id}', 'ProjetController@download')->name('downloadfile');
Route::get('/projet-open/{id}', 'ProjetController@open')->name('projet.open');
Route::post('/projet-close/', 'ProjetController@close')->name('projet.close');


// Administrateur
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', 'Admin\DashboardController@data')->name('admin_dashboard');;
    Route::get('/user-register', 'Admin\DashboardController@registered')->name('admin_users');;
    Route::get('/projet-register', 'Admin\DashboardController@posted')->name('admin_projets');
    Route::get('/user-edit/{id}', 'Admin\DashboardController@registeredit');
    Route::put('/user-register-update/{id}', 'Admin\DashboardController@registerupdate');
    Route::get('/projet-edit/{id}', 'Admin\DashboardController@projetedit');
    Route::put('/projet-register-update/{id}', 'Admin\DashboardController@projetupdate');
    Route::delete('/user-delete/{id}', 'Admin\DashboardController@registerdelete' );
    Route::delete('/projet-delete/{id}', 'Admin\DashboardController@projetdelete');
    Route::get('/projet-by-user/{id}', 'Admin\DashboardController@projetbyuser');
    Route::get('/connect-as/{id}', 'Admin\DashboardController@connect_as')->name('connect_as');
});

//Offers
Route::get('/offer/{id}', 'OfferController@create')->name('offers.create');
Route::get('/offer/edit/{id}', 'OfferController@edit')->name('offers.edit');
Route::post('/offer/{id}', 'OfferController@update')->name('offers.update');
Route::post('/offer/', 'OfferController@store')->name('offers.store');
Route::delete('/offer/{id}', 'OfferController@destroy')->name('offers.delete');

//Profil
Route::get('/profil/{id}', 'UserController@show')->name('profil');
Route::get('/profil/edit/{id}', 'UserController@edit')->name('profil-edit');
Route::post('/profil/edit/{id}', 'UserController@update')->name('profil-update');

//Upload avatar
Route::post('image-upload', 'UserController@imageUpload')->name('image.upload');

//Sentry
// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error!');
// });

//Messagerie
Route::get('/messagerie/{topic}/{projet}', 'ConversationController@show')->name('messagerie.show');
Route::get('/messagerie-index/{projet}', 'ConversationController@index')->name('messagerie.index');
Route::get('/messagerie-download/{message}', 'ConversationController@download')->name('messagerie.download');
Route::post('/messagerie/{topic}', 'ConversationController@store')->name('messagerie.store');



