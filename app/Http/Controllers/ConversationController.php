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
use Illuminate\Support\Facades\Storage;
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
        if ($files = $request->file('file_message')) {
            $rules = [
            ];
        }else{
            $rules = [
                'content' => 'required',
            ];
        }

        $validator = Validator::make($values, $rules,[
            'content.required' => 'Veuillez écrire votre message',
            'file-message' => 'sometimes|max:5000',
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

        }

        if ($files = $request->file('file_message')) {

                    $filenamewithextension = $request->file('file_message')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('file_message')->getClientOriginalExtension();

            //filename to store
            //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

            $filenametostore = $filename.'_'.time().'.'.$extension;


                        //Upload File

                        Storage::putFileAs('documents', $request->file('file_message'), $filenametostore, );

                        //Store $filenametostore in the database
                        
                        $message->file_message = $filenametostore;

            }
        $message->save();
        

        return redirect()->route('messagerie.show', ['projet' => $projet, 'topic' =>$topic]);
    }

    public function download($message)
    {

        $dl = Message::find($message);
        return Storage::download('documents/' . $dl->file_message);

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
