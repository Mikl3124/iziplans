<?php

namespace App\Http\Controllers;

use Validator;
use App\Model\User;
use App\model\Competence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::find($id);
        $avatar = Storage::disk('s3')->url('users/normal/'. $user->avatar);

        return view('users.show', compact('user', 'avatar'));
    }

    public function edit($id)
    {
        $competences = Competence::all();
        $user = User::find($id);
        $avatar = Storage::disk('s3')->url('users/normal/'. $user->avatar);
        $user = Auth::user();
        return view('users.edit', compact('user', 'avatar', 'competences'));
    }

    public function imageUpload(Request $request)
    {
        $user = Auth::user();

        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $avatar = $request->file('avatar');
        $extension = $request->file('avatar')->getClientOriginalExtension();

        $filename = md5(time()).'_'.$avatar->getClientOriginalName();
        $normal = Image::make($avatar)->resize(160, 160)->encode('png', 75);
        $medium = Image::make($avatar)->resize(80, 80)->encode('png', 75);
        $small = Image::make($avatar)->resize(40, 40)->encode('png', 75);

        Storage::disk('s3')->put('/users/normal/'.$filename, (string)$normal, 'public');

        Storage::disk('s3')->put('/users/medium/'.$filename, (string)$medium, 'public');

        Storage::disk('s3')->put('/users/small/'.$filename, (string)$small, 'public');

        $user->avatar = $filename;
        $user->save();

        return redirect()->back();

    }

    public function update(Request $request)
    {
        $user = Auth::user();
        DB::table('competence_user')->where('user_id', $user->id)->delete();
        $user->competences()->attach($request->competences);
        return redirect()->back();
    }

}
