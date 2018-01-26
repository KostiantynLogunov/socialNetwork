<?php

namespace Chatty\Http\Controllers;

use Chatty\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\PrettyPrinter\Standard;

class StatusController extends Controller
{
    public function postStatus(Request $request) {
        $this->validate($request, [
            'status'=>'required|max:1000',
        ]);

        Auth::user()->statuses()->create([
            'body'=> $request->input('status'),
        ]);

        return redirect()->route('home')->with('info', 'status posted');
    }

    public function postReplay(Request $request, $statusId) {
        $this->validate($request, [
            "reply-$statusId" =>'required|max:1000'
        ], [
            'required' => 'The reply body is required'
        ]);

        $status = Status::notReply()->find($statusId);

        if (!$status) {
            return redirect()->route('home');
        }

        if (!Auth::user()->isFriendWith($status->user) && Auth::user()->id !== $status->user->id) {
            return redirect()->route('home');
        }

        $reply = Status::create([
            'body'=> $request->input("reply-$statusId"),
        ])->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();
    }

    public function getLike($statusId) {
        $status= Status::find($statusId);

        if (!$status) {
            return redirect()->route('home');
        }

        if (!Auth::user()->isFriendWith($status->user)) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasLikedStatus($status)) {
            return redirect()->back()->with('info', 'has already liked');
        }

        $like = $status->likes()->create([

        ]);
        Auth::user()->likes()->save($like);
        return redirect()->back();
    }
}
