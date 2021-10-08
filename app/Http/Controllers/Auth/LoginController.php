<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Projet;
use Illuminate\Http\Request;
use App\Mail\NewSubscription;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use App\Mail\ConfirmMessageToAuthor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewProjetPostedForAdmin;
use Intervention\Image\Facades\Image;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = ('/');

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Twitter authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }



    /**
     * Obtain the user information from Twitter.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        $user = Socialite::driver($provider)->stateless()->user();

        $existingUser = User::whereEmail($user->getEmail())->first();

        // Si un projet est en session
        if (session('filled_form')) {

          $role = 'client';

          if ( Session::get('role') ) {
              $role = Session::get('role');
              // Destroy role session here
              Session::forget('role');
          }
          $avatar =  $user->getAvatar();


          // On découpe le nom de l'user pour récupérer firstname / lastname
          $name = trim($user->name);
          $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
          $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );

          if($user->email === null){
              $email = $user->id. '@email.fr';
          }else{
              $email = $user->email;
          }

          if ($existingUser) {
            $newUser = $existingUser;
            $newUser->update([
              'last_login_at' => Carbon::now()->toDateTimeString(),
              'number_of_connections' => $existingUser->number_of_connections + 1,
            ]);
          }else {
            $newUser = new User;
          }

          $newUser->firstname = $first_name;
          $newUser->lastname = $last_name;
          $newUser->email = $email;
          $newUser->email_verified_at = Carbon::now();
          $newUser->avatar = $avatar;
          $newUser->role = $role;
          $newUser->number_of_connections = 0;
          $newUser->provider = $provider;
          $newUser->password = Hash::make('5yr20mffdsPa$$wOrd');
          $newUser->cgv = true;

          $newUser->save();

          Mail::to($newUser->email)
          ->send(new NewSubscription($newUser));

          auth()->login($newUser);

          $values = Session::get('filled_form');

          $projet = new Projet;
          $projet->user_id = $newUser->id;
          $projet->title = $values['title'];
          $projet->description = $values['description'];
          $projet->status = 'pending';
          $projet->departement_id = $values['departement'];
          $projet->budget_id = $values['budget'];
          $projet->save();
          $projet->categories()->attach($values['categories']);

          Session::flash('success', '🎉 Merci ' . $newUser['firstname'] . ', votre projet a été enregistré avec succès, notre équipe va bientôt le valider.');

          Mail::to($newUser->email)
          ->send(new ConfirmMessageToAuthor($projet, $newUser));

          //Mail à l'Admin
          Mail::to(env("MAIL_ADMIN"))
          ->send(new NewProjetPostedForAdmin($projet, $newUser));
          return redirect($this->redirectPath());
        }

        if($existingUser) {
                auth()->login($existingUser);
                $existingUser->update([
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                    'number_of_connections' => $existingUser->number_of_connections + 1,
        ]);
                return redirect($this->redirectPath());
            }

        $role = 'client';

        if ( Session::get('role') ) {
            $role = Session::get('role');
            // Destroy role session here
            Session::forget('role');
        }
        $avatar =  $user->getAvatar();


        // On découpe le nom de l'user pour récupérer firstname / lastname
        $name = trim($user->name);
        $last_name = (strpos($name, ' ') === false) ? '' : preg_replace('#.*\s([\w-]*)$#', '$1', $name);
        $first_name = trim( preg_replace('#'.$last_name.'#', '', $name ) );

        if($user->email === null){
            $email = $user->id. '@email.fr';
        }else{
            $email = $user->email;
        }

        $newUser = new User;

            $newUser->firstname = $first_name;
            $newUser->lastname = $last_name;
            $newUser->email = $email;
            $newUser->email_verified_at = Carbon::now();
            $newUser->avatar = $avatar;
            $newUser->role = $role;
            $newUser->number_of_connections = 0;
            $newUser->provider = $provider;
            $newUser->password = Hash::make('5yr20mffdsPa$$wOrd');
            $newUser->cgv = true;

            $newUser->save();

        auth()->login($newUser);

        Flashy::success('Bienvenue '. $newUser->firstname);

        //Mail à l'utilisteur inscrit
        Mail::to($newUser->email)
        ->send(new NewSubscription($newUser));
        dd(env("MAIL_ADMIN"));

        ///Mail à l'admin
        Mail::to(env("MAIL_ADMIN"))
        ->send(new NewSubscription ($newUser));

        return redirect($this->redirectPath());

        // $user->token;
    }

    //On récupère la date de la dernière connection de l'utilsateur et on ajoute 1 au nombre de connections
    function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'number_of_connections' => $user->number_of_connections + 1,
        ]);
    }

    }
