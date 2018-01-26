<?php

namespace Chatty\Http\Controllers;

use Chatty\Friend;
use Chatty\Message;
use Chatty\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function getResult(Request $request) {

        $query = $request->input('query');
//        dd($query);

        if (!$query) {
            return redirect()->route('home');
        }

        if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
            $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
        }
        if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
            $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
        }
        $users = User::where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'LIKE', "%{$query}%")
                    ->orWhere('username', 'LIKE', "%{$query}%")
                    ->get();

        return view('search.results',[
                'countRequests'=>$countRequests,
                'newMessages'=>$newMessages
        ])->with('users', $users);
    }
}
