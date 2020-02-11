<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('users.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        if ($files = $request->file('avatar')) {
            $filenamewithextension = $request->file('avatar')->getClientOriginalName();
    
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
            //get file extension
            $extension = $request->file('avatar')->getClientOriginalExtension();
    
            //filename to store
            $path = 'documents/' . $user->lastname. '_' . $user->firstname;
            $filenametostore = $path.'/'.$filename.'_'.time().'.'.$extension;
    
            //Upload File to s3
            Storage::disk('s3')->put($filenametostore, fopen($request->file('avatar'), 'r+'), 'public');
            //Store $filenametostore in the database
            $user->avatar = $filenametostore;
            $user->save();
            return redirect()->back();
        }
        
    }


}
