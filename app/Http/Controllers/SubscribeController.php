<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use App\Subscription;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\NewSubscription;
use Illuminate\Validation\Rule;
use App\Mail\CancelSubscription;
use MercurySeries\Flashy\Flashy;
use App\Mail\DestroySubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class SubscribeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function payment()
    {
        if (Auth::user()->role === 'freelance') {
            $user = Auth::user();
            return view('subscribe', [
                'intent' => $user->createSetupIntent()
            ]);
        }
        return redirect()->route('home');
    }
    public function subscribe(Request $request)
    {

        $user = $request->user();
        $paymentMethod = $request->paymentMethod;

        request()->validate([
            'plan' => ['required', Rule::in([
                'price_1JBH7JC1QIYXU5hhuk6QAils',
                'price_1HLnOwC1QIYXU5hh2r9IsgCS',
                'price_1HLnPkC1QIYXU5hhQfpujV4V',
            ])],
        ]);
        $plan = request()->plan;
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);

        $user->newSubscription('abonnement', $plan)->create(request()->stripeToken);


        Mail::to(auth()->user())->send(new NewSubscription($user));
        Mail::to('mickael.delpech@gmail.com')->send(new NewSubscription($user));

        Flashy::success('Félicitations! Vous êtes maintenant abonné, vous pouvez répondre aux offres');

        if (Session::has('backUrl')) {
            Session::keep('backUrl');
        }
        return ($url = Session::get('backUrl'))
            ? Redirect::to($url)
            : Redirect::route('home');
    }

    public function cancel()
    {
        $user = Auth::user();
        if ($user->subscription('abonnement')->cancel()) {
            Flashy::success('Votre abonnement a été suspendu avec succès');
            Mail::to(env("MAIL_ADMIN"))
                ->send(new DestroySubscription($user));
            return redirect()->back();
        };
        Flashy::error('Une erreur est survenue, veuillez nous contacter');
        return redirect()->back();
    }

    public function resume()
    {
        $user = Auth::user();
        if ($user->subscription('abonnement')->resume()) {
            Flashy::success('Félicitations! Votre abonnement est à nouveau actif !');
            return redirect()->back();
        };
        Flashy::error('Une erreur est survenue, veuillez nous contacter');
        return redirect()->back();
    }
}
