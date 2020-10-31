<?php

use App\Http\Middleware\CheckSubscribe;
use Illuminate\Http\Request;

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
Route::get('/home', 'HomeController@list')->name('home');

//Register
Auth::routes();
Route::get('/profil_choice', 'UserController@register_choice')->name('register_choice');
Route::get('/register_client', 'UserController@register_client')->name('register_client');
Route::get('/register_freelance', 'UserController@register_freelance')->name('register_freelance');
Route::get('/register/', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register/', 'Auth\RegisterController@register');


//Social Register
Route::get('social-login/{provider}', 'Auth\LoginController@redirectToProvider')->name('social-login.redirect');
Route::get('social-login/{provider}/callback/', 'Auth\LoginController@handleProviderCallback')->name('social-login.callback');

//Stripe
Route::post('/subscribe', 'SubscribeController@subscribe');
Route::get('/abonnement/{id}', 'UserController@subscription')->name('subscription');
Route::get('subscribe', 'SubscribeController@payment')->name('subscribe');
Route::post('/unsubscribe', 'SubscribeController@destroy');
Route::post('/resume', 'SubscribeController@resume')->name('resume-subscription');
Route::post('/cancel', 'SubscribeController@cancel')->name('cancel-subscription');
Route::post('/stripe', 'StripeWebhooksController');
Route::get('user/invoice/{invoice}', function (Request $request, $invoiceId) {
    return $request->user()->downloadInvoice($invoiceId, [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
    ]);
});

//Projet
Route::resource('projet', 'ProjetController');
Route::get('/projet/download/{id}', 'ProjetController@download')->name('downloadfile');
Route::get('/projet-open/{id}', 'ProjetController@open')->name('projet.open');
Route::post('/projet-close/', 'ProjetController@close')->name('projet.close');
Route::get('/projet-list/', 'ProjetController@list')->name('projet.list');
Route::get('/myprojet-list/', 'ProjetController@myprojets')->name('myprojets');



// Administrateur
Route::group(['middleware' => ['auth','admin']], function () {
    Route::get('/dashboard', 'Admin\DashboardController@data')->name('admin.dashboard');;
    Route::get('/users-list', 'Admin\DashboardController@usersList')->name('admin.users.list');;
    Route::get('/projets-list', 'Admin\DashboardController@projetsList')->name('admin.projets.list');
    Route::get('/user-edit/{id}', 'Admin\DashboardController@userEdit')->name('admin.user.edit');
    Route::put('/user-update/{id}', 'Admin\DashboardController@userUpdate')->name('admin.user.update');
    Route::get('/projet-edit/{id}', 'Admin\DashboardController@projetEdit')->name('admin.projet.edit');
    Route::get('/offer-edit/{id}', 'Admin\DashboardController@offerEdit')->name('admin.offer.edit');
    Route::put('/projet-update/{id}', 'Admin\DashboardController@projetUpdate')->name('admin.projet.update');
    Route::delete('/user-delete/{id}', 'Admin\DashboardController@userdelete')->name('admin.user.delete');
    Route::delete('/projet-delete/{id}', 'Admin\DashboardController@projetDelete')->name('admin.projet.delete');
    Route::get('/projets-by-user/{id}', 'Admin\DashboardController@projetsByUser')->name('admin.projets.by.user');;
    Route::get('/offers-by-user/{id}', 'Admin\DashboardController@offersByUser')->name('admin.offers.by.user');
    Route::get('/connect-as/{id}', 'Admin\DashboardController@connect_as')->name('admin.connect_as');
    Route::post('/projet-validate/', 'ProjetController@validateProjet')->name('admin.projet.validate');
});

//Offers

Route::get('/offers/{id}', 'OfferController@show')->name('offers.show');
Route::get('/offers-create/{id}', 'OfferController@create')->name('offers.create')->middleware(CheckSubscribe::class);
Route::get('/offers/edit/{id}', 'OfferController@edit')->name('offers.edit')->middleware(CheckSubscribe::class);
Route::post('/offers/{id}', 'OfferController@update')->name('offers.update')->middleware(CheckSubscribe::class);
Route::post('/offers/', 'OfferController@store')->name('offers.store')->middleware(CheckSubscribe::class);
Route::delete('/offers/{id}', 'OfferController@destroy')->name('offers.delete')->middleware(CheckSubscribe::class);


//Profil
Route::get('/profil/{id}', 'UserController@show')->name('profil');
Route::get('/profil/edit/{id}', 'UserController@edit')->name('profil-edit');
Route::post('/profil/edit/{id}', 'UserController@update')->name('profil-update');
Route::post('/profil/password/{id}', 'UserController@changePassword')->name('change.password');
Route::get('change-profil', 'UserController@changeRole')->name('changeRole');

//Upload avatar
Route::post('image-upload', 'UserController@imageUpload')->name('image.upload');

//Sentry
// Route::get('/debug-sentry', function () {
//     throw new Exception('My first Sentry error!');
// });

//Messagerie
Route::get('/messagerie/{topic}/{projet}', 'ConversationController@show')->name('messagerie.show')->middleware(CheckSubscribe::class);
Route::get('/messagerie-index/{projet}', 'ConversationController@index')->name('messagerie.index');
Route::get('/messagerie-download/{message}', 'ConversationController@download')->name('messagerie.download');
Route::post('/messagerie/{topic}', 'ConversationController@store')->name('messagerie.store')->middleware(CheckSubscribe::class);
Route::get('showFromNotifications/{topic}/{notification}', 'ConversationController@showFromNotifications')->name('topics.showFromNotifications');


//BLOG
Route::get('/blog/', 'BlogController@index')->name('blog.index');
Route::get('/blog/{id}', 'BlogController@show')->name('article.show');

//Divers
Route::get('/mentions-legales', 'HomeController@cgv')->name('cgv');
Route::get('/politique-de-confidentialite', 'HomeController@politique')->name('politique');
