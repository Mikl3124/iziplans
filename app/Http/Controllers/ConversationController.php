<?php

namespace App\Http\Controllers;

use Auth;
use Validator;
use App\Model\User;
use App\Model\Topic;
use App\Model\Projet;
use App\Model\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ConversationController extends Controller
{
    public function index(){

        $users = User::select('firstname', 'id')->where('id', '!=', Auth::user()->id)->get();
        $topics= Topic::select('title', 'id')->where('to_id', Auth::user()->id)->get();
        //$projets = Projet::whereHas('messages')->get();

        return view('messagerie.index', compact('users', 'topics'));
    }

    public function show($projet){
        $user = Auth::user();
        $projet = Projet::find($projet);
        $users = User::select('firstname', 'id')->where('id', '!=', Auth::user()->id)->get();
        $topic = Topic::where('projet_id', $projet->id)
                        ->where('from_id', $user->id)
                        ->orwhere('to_id', $user->id)
                        ->get();
        $messages = Message::where('from_id', $user->id)
                            ->orwhere('to_id', $user->id)
                            ->get();
        return view('messagerie.show', compact('users','messages', 'projet', 'user', 'topic'));
    }

    public function store(Request $request, $projet){

        $projet = Projet::find($projet);
        $values = $request->all();
        $thread = $projet->id . $projet->user->id . Auth::user()->id;

        $rules = [
            'content' => 'required',
        ];

        $validator = Validator::make($values, $rules,[
            'content.required' => 'Veuillez écrire votre message',
          ]);
        if($validator->fails()){

        return Redirect::back()
            ->withErrors($validator)
            ->withInput();

        }

        $topic = new Topic;
                    $topic->title = $projet->title;
                    $topic->from_id = Auth::user()->id;
                    $topic->to_id = $request->to_id;
                    $topic->projet_id = $projet->id;

        $topic->save();

        $message = new Message;
                    $message->content = $request->content;
                    $message->from_id = Auth::user()->id;
                    $message->to_id = $request->to_id;
                    $message->projet_id = $projet->id;
                    $message->thread = $thread;
                    $message->topic_id = $topic->id;

        $message->save();

        return redirect()->back()->with(compact('projet'));
    }

    public function unreadCount($userId){
        $unread = Message::where('to_id', $userId)
                    ->groupBy('from_id')
                    ->selectRaw('from_id, COUNT(id) as count')
                    ->whereRaw('read_at IS NULL')
                    ->get()
                    ->pluck('count', 'from_id');
    }
}
