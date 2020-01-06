<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\NewSubscription;
use Illuminate\Validation\Rule;
use App\Mail\CancelSubscription;
use App\Mail\DestroySubscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubscribeController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function payment()
    {
        $user = Auth::user();

        return view('subscribe', [
            'intent' => $user->createSetupIntent()
            
        ]); 
    }
    public function subscribe(Request $request)
    {

        $user = $request->user();
        $paymentMethod = $request->paymentMethod;

        request()->validate([
            'plan' => ['required', Rule::in([
                                            'iziplans_monthly',
                                            'iziplans_trimester',
                                            'iziplans_yearly',
                                            ])],
        ]);
        $plan = request()->plan;
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);            

        $user->newSubscription('abonnement', $plan)->create(request()->stripeToken);


        Mail::to(auth()->user())->send(new NewSubscription($user));
        Mail::to('mickael.delpech@gmail.com')->send(new NewSubscription($user));

        return redirect('home')->with('subscription', 'Félicitations! Vous êtes maintenant abonné, vous pouvez répondre aux offres');
    }

    public function cancel()
    {
        $user = auth()->user();
        $user->subscription('abonnement')->cancel();

        Mail::to(auth()->user())->send(new DestroySubscription($user));

        return redirect('home')->with('cancel_subscription', 'Vous êtes désabonné avec succès');
    }
}
