<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
  public function connect_as($user)
  {
      if(Auth::user()->role === 'admin'){
          Auth::loginUsingId($user, true);
          return redirect()->back();
      }
      return redirect()->back();

  }
}
