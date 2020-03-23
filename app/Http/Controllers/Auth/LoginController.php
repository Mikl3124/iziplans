<?php

namespace App\Http\Controllers\Auth;

use Session;
use Carbon\Carbon;
use App\Model\User;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Providers\RouteServiceProvider;
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

        if($existingUser) {
                auth()->login($existingUser);
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
            $newUser->provider = $provider;
            $newUser->password = Hash::make('5yr20mffdsPa$$wOrd');
            $newUser->cgv = true;

            $newUser->save();

        auth()->login($newUser);

        Flashy::success('Bienvenue '. $newUser->firstname);
        return redirect($this->redirectPath());

        // $user->token;
    }

}
