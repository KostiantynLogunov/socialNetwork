<?php

namespace Chatty\Http\Controllers;

use Chatty\Friend;
use Chatty\Message;
use Chatty\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getProfile($username) {
        $user = User::where('username', $username)->first();
        if (!$user) {
            abort(404);
        }

        $statuses = $user->statuses()->notReply()->get();
        if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
            $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
        }

        if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
            $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
        }
        return view('profile.index', [
            'user'=>$user,
            'statuses'=> $statuses,
            'authUserIsFriend'=> Auth::user()->isFriendWith($user),
            'countRequests'=>$countRequests,
            'newMessages'=>$newMessages
        ]);
    }

    public function getEdit() {
        if (Friend::where('user_id',Auth::user()->id)->where('accepted',0)->get()) {
            $countRequests = Friend::where('user_id',Auth::user()->id)->where('accepted',0)->count();
        }
        if (Message::where('to_user_id',Auth::user()->id)->where('readed',0)->get()) {
            $newMessages = Message::where('to_user_id',Auth::user()->id)->where('readed',0)->count();
        }
        return view('profile.edit',[
            'countRequests'=>$countRequests,
            'newMessages'=>$newMessages
            ]);
    }

    public function postEdit(Request $request) {
        $this->validate($request, [
            'first_name'=>'alpha|max:50',
            'last_name'=>'alpha|max:50',
            'location'=>'alpha|max:20'
        ]);
        Auth::user()->update($request->all());
        /*Auth::user()->update([
            'first_name'=> $request->input('first_name'),
            'last_name'=> $request->input('last_name'),
            'location'=> $request->input('location')
        ]);*/

        return redirect()->route('profile.edit')->with('info', 'Your profile has been updated');

    }
}
