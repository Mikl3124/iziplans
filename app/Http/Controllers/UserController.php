<?php

namespace App\Http\Controllers;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
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
                
            $avatar = $request->file('avatar');
            $extension = $request->file('avatar')->getClientOriginalExtension();

            $filename = md5(time()).'_'.$avatar->getClientOriginalName();

            $normal = Image::make($avatar)->resize(160, 160)->encode($extension);
            $medium = Image::make($avatar)->resize(80, 80)->encode($extension);
            $small = Image::make($avatar)->resize(40, 40)->encode($extension);

            Storage::disk('s3')->put('/users/'. $user->firstname . '_' . $user->lastname . '/normal/'.$filename, (string)$normal, 'public');

            Storage::disk('s3')->put('/users/'. $user->firstname . '_' . $user->lastname . '/medium/'.$filename, (string)$medium, 'public');

            Storage::disk('s3')->put('/users/'. $user->firstname . '_' . $user->lastname . '/small/'.$filename, (string)$small, 'public');

            $user->avatar = $filename;
            $user->save();

            return redirect()->back();
        }
    }
        
}