<?php

namespace App\Http\Controllers\Auth;

use Session;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
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
         if ( Session::get('filled_form') ){
            $role = Session::get('filled_form');
            Session::forget('filled_form');
         }

        $user = Socialite::driver($provider)->user();

        $existingUser = User::whereEmail($user->getEmail())->first();

        if($existingUser) {
                auth()->login($existingUser);
                return redirect($this->redirectPath());
            }
            $newUser = User::create([
                'firstname' => $user->getNickname(),
                'lastname' => $user->getName(),
                'email' => $user->getEmail(),
                'avatar' => $user->getAvatar(),
                'role' => $role,
                'email_verified_at' => now(),
                'password' => Hash::make('5yr20mffdsPa$$wOrd'),
                'cgv' => true,
            ]);
            auth()->login($newUser);
            return redirect($this->redirectPath());

        // $user->token;
    }

}
