<?php

namespace Chatty\Http\Controllers;

use Chatty\Friend;
use Chatty\Message;
use Chatty\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index() {
        if (Auth::check()) {
            $statuses = Status::notReply()->where(function ($query) {
               return $query->where('user_id', Auth::user()->id)
                            ->orWhereIn('user_id', Auth::user()->friends()->pluck('id')
                                );
            })->orderBy('created_at', 'desc')->paginate(10);

            if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
                $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
            }

            if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
                $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
            }

            return view('timeline.index', [
                'countRequests'=>$countRequests,
                'statuses'=>$statuses,
                'newMessages'=>$newMessages
            ]);
        }
        return view('home');
    }
}
