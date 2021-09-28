<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Model\Projet;
use App\Jobs\MailNewUser;
use App\Mail\NewSubscription;
use Illuminate\Validation\Rule;
use MercurySeries\Flashy\Flashy;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'lastname' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'my_name'   => 'honeypot',
            'my_time'   => 'required|honeytime:5',
            'role' =>  ["required" , "max:255", "regex:(client|freelance)"],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'cgv' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    protected function create(array $data)
    {
        if (session('filled_form')) {
            $user = User::create([
                'firstname' => $data['firstname'],
                'lastname' => $data['lastname'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
                'cgv' => true,
                'number_of_connections' => 0
            ]);
            $this->dispatch(new MailNewUser($user));

            $values = Session::get('filled_form');


            $projet = new Projet;
            $projet->user_id = $user->id;
            $projet->title = $values['title'];
            $projet->description = $values['description'];
            $projet->status = 'pending';
            $projet->departement_id = $values['departement'];
            $projet->budget_id = $values['budget'];
            $projet->save();
            $projet->categories()->attach($values['categories']);

            Session::flash('success', '🎉 Merci ' . $data['firstname'] . ', votre projet a été enregistré avec succès, notre équipe va bientôt le valider.');
            //Flashy::success('🎉 Merci ' . $data['firstname'] . ', votre projet a été enregistré avec succès, notre équipe va bientôt le valider.');

            return $user;
        }

        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'cgv' => true,
            'number_of_connections' => 0
        ]);
        //$this->dispatch(new MailNewUser($user));
        return $user;
    }
}
