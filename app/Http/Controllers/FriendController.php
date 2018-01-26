<?php

namespace Chatty\Http\Controllers;

use Chatty\Friend;
use Chatty\Message;
use Chatty\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getIndex() {
        $friends = Auth::user()->friends();
        $requests = Auth::user()->friendRequest();
        if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
            $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
        }

        if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
            $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
        }
        return view('friends.index', [
            'friends'=>$friends,
            'requests'=>$requests,
            'countRequests'=>$countRequests,
            'newMessages'=>$newMessages
        ]);
    }

    public function getAdd($username) {
        $user = User::where('username', $username)->first();
        if (!$user) {
            return redirect()->route('home')->with('info', 'That user could not be found');
        }

        if (Auth::user()->id === $user->id) {
            return redirect()->route('home');
        }

        if (Auth::user()->hasfriendRequestPending($user) || $user->hasfriendRequestPending(Auth::user())) {
            return redirect()->route('profile.index',['username'=>$user->username])
                ->with('info', 'Friend request already panding.');
        }

        if (Auth::user()->isFriendWith($user)) {
            return redirect()->route('profile.index', ['username'=>$user->username])
                ->with('info', ' You are already frieands.');
        }

        Auth::user()->addFriend($user);
        return redirect()->route('profile.index', ['username'=>$user->username])
            ->with('info', 'Friend request sent.');
    }

    public function getAccept($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->route('home')->with('info', 'That user could not be found');
        }

        if (!Auth::user()->hasfriendRequestReceived($user)) {
            return redirect()->route('home');
        }

        Auth::user()->acceptFriendRequest($user);
        /*$friend = Friend::Friend::where('user_id',Auth::user()->id)->where('friend_if',$user->id)->first();
        $friend->update([
            'a'
        ])*/
        return redirect()->route('profile.index', ['username'=>$username])
            ->with('info','Friend request accepted');
    }

    public function postDelete($username) {
        $user = User::where('username', $username)->first();

        if (!Auth::user()->isFriendWith($user)) {
            return redirect()->back();
        }
//                ->with('info', ' You are already frieands.');
            //delete friend
        Auth::user()->deleteFriend($user);
        return redirect()->back()->with('info','Friend deleted.');
    }
}
