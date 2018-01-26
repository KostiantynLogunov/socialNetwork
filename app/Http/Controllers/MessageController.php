<?php

namespace Chatty\Http\Controllers;

use Chatty\Conversation;
use Chatty\Friend;
use Chatty\Message;
use Chatty\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function postMessage(Request $request, $username) {
        $this->validate($request, [
            'bodyMessage' => 'required|max:1000'
        ]);

        $userTo = User::where('username', $username)->first();

        if (Conversation::where('user_one', Auth::user()->id)->where('user_two', $userTo->id)->first()) {
            $conversation_id = Conversation::where('user_one', Auth::user()->id)->where('user_two', $userTo->id)->first()->id;
        }
        elseif (Conversation::where('user_one', $userTo->id)->where('user_two', Auth::user()->id)->first()) {
            $conversation_id = Conversation::where('user_one', $userTo->id)->where('user_two', Auth::user()->id)->first()->id;
        }
        else {
            Conversation::create([
                'user_one' => Auth::user()->id,
                'user_two' => $userTo->id,
            ]);
            $conversation_id = Conversation::where('user_one', Auth::user()->id)->where('user_two', $userTo->id)->first()->id;

        }

        Message::create([
                'from_user_id' => Auth::user()->id,
                'to_user_id' =>$userTo->id,
                'conversation_id' => $conversation_id,
                'text' => $request->bodyMessage,

        ]);
//        dd($conversation_id);

        return redirect()->back()->with('info', 'Message send.');
    }

    public function getMessages() {
        if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
            $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
        }

        if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
            $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
        }


        $conversations = Conversation::where('user_one', Auth::user()->id)->orWhere('user_two', Auth::user()->id)->get();

        return view('messages.message', [
            'countRequests'=>$countRequests,
            'newMessages'=>$newMessages,
            'conversations' => $conversations
        ]);
    }

    public function readMessages($conversation_Id) {

        Message::where('conversation_Id', $conversation_Id)->where('to_user_id', Auth::user()->id)->update(['readed'=>1]);

        if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
            $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
        }

        if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
            $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
        }

        $conversation = Conversation::find($conversation_Id);
        if ($conversation->user_one == Auth::user()->id) {
            $userSecondId = $conversation->user_two;
        }
        else {
            $userSecondId = $conversation->user_one;
        }

        $userSecond = User::where('id', $userSecondId)->first();

        $chat = Message::where('conversation_Id', $conversation_Id)->orderBy('created_at', 'asc')->get();
        return view('messages.read', [
            'chat' => $chat,
            'userSecond' => $userSecond,
            'countRequests'=>$countRequests,
            'newMessages'=>$newMessages,
        ]);
    }
}
