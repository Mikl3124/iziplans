<?php

namespace App\Http\Middleware;

use Closure;
use MercurySeries\Flashy\Flashy;

class CheckSubscribe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
{
    if ($request->user() && ! $request->user()->subscribed('abonnement') && ($request->user()->role) === 'freelance'){
        // This user is not a paying customer
        Flashy::error('Un abonnement est nécessaire pour accéder à cette section');
        return redirect()->route('subscribe');
    }

    return $next($request);
}
}
