<?php

namespace Chatty\Http\Controllers;

use Chatty\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getSignup() {
        return view('auth.signup');
    }

    public function postSignup(Request $request) {
        $this->validate($request, [
           'username' => 'required|unique:users|max:20|alpha_dash',
           'email' => 'required|unique:users|email|max:50',
           'password' => 'required|min:6'
        ]);

        User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        return redirect()
            ->route('home')
            ->with('info', 'Your account has been created and you can now sign in.');
    }

    public function getSignin() {
        return view('auth.signin');
    }

    public function postSignin(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|max:50',
            'password' => 'required|min:6'
        ]);

        if (!Auth::attempt($request->only(['email', 'password']), $request->has('remember'))) {
            return redirect()
                ->back()
                ->with('info', 'Could not sign you in with those details.')
                ->withInput();
        }
        return redirect()->route('home')->with('info', 'You are now sign in.');
    }
}
