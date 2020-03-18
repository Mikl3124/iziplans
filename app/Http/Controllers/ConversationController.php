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
        // $message = Message::where('to_id', Auth::user()->id)
        //                     ->orwhere('from_id', Auth::user()->id)
        //                     ->latest('created_at')
        //                     ->first();

        $topics = Topic::where('to_id', Auth::user()->id)
                            ->orwhere('from_id', Auth::user()->id)
                            ->get();
        //$projets = Projet::whereHas('messages')->get();

        return view('messagerie.index', compact('users','topics'));
    }

    public function show($topic, $projet){

        $topic = Topic::find($topic);
        $projet = Projet::find($projet);
        if($topic){
            $user = Auth::user();
            $users = User::select('firstname', 'id')->where('id', '!=', Auth::user()->id)->get();
            
            $messages = Message::where('topic_id', $topic->id)
                                ->where(function($query) use ($topic) {
                                    $query  ->where('to_id', Auth::user()->id)
                                            ->orwhere('from_id', Auth::user()->id);
                                })
                                ->get();

            return view('messagerie.show', compact('users','projet', 'messages', 'user', 'topic'));
        }

        $user = Auth::user();
        $users = User::select('firstname', 'id')->where('id', '!=', Auth::user()->id)->get();

            return view('messagerie.show', compact('users','projet', 'user'));

    }

    public function store(Request $request, $projet){

        $projet = Projet::find($projet);
        $values = $request->all();
        $topic = Topic::find($request->topic_id);

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

        if ($topic === null) {

            $topic = new Topic;
                        $topic->title = $projet->title;
                        $topic->from_id = Auth::user()->id;
                        $topic->to_id = $request->to_id;
                        $topic->projet_id = $projet->id;

            $topic->save();
        } 
        
        $message = new Message;
                    $message->content = $request->content;
                    $message->from_id = Auth::user()->id;
                    $message->to_id = $request->to_id;
                    $message->projet_id = $projet->id;
                    $message->topic_id = $topic->id;

        if(($topic->from_id === Auth::user()->id) || ($topic->to_id === Auth::user()->id)){
            $message->save();
        }
        

        return redirect()->route('messagerie.show', ['projet' => $projet, 'topic' =>$topic]);
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
