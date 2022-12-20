<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create() {
        return view('users.register');
    }

    public function store(Request $request) {
        $input = $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&^]/'
        ]);

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        auth()->login($user);

        return redirect('/')->with('success', 'The user was created successfully');
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');

    }

    public function login() {
        return view('users.login');
    }

    public function authenticate(Request $request) {
        $input = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        if(auth()->attempt($input)) {
            $request->session()->regenerate();

            return redirect('/')->with('success', 'Logged in successfully.');
        }

        return back()->withErrors(['email'=>'Invalid Credentials']);
    } 

    public function dashboard() {
        return view('users.dashboard', [
            'listings' => auth()->user()->listings()->get()
        ]);
    }

}
