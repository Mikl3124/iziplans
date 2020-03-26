<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeWebhooksController extends Controller
{
    public function __invoke(){
        if (request('type') === 'charge.succeded')
            return 'Charge succeded received';
    }

}
