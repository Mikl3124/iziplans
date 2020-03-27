<?php

namespace App\Http\Controllers;

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

        Flashy::success('Félicitations! Vous êtes maintenant abonné, vous pouvez répondre aux offres');

        return redirect()->route('home');

    }

    public function cancel()
    {
        $user = Auth::user();
        $user->subscription('abonnement')->cancel();

        return redirect()->back();
    }
}
