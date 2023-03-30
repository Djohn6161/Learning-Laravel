<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show registraion form 
    public function create(){
        return view('users.register');
    }
    // Create New User
    public function store(Request $request){
        $formfields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => 'required|unique:listings,company',
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash Password
        $formfields['password'] = bcrypt($formfields['password']);

        // Create User
        $user = User::create($formfields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User Created and Logged in');

    }
    // User Logout
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');

    }

    // Show Login Form
    public function login(){
        return view('users.login');
    }
    // Authenticate User
    public function authenticate(Request $request){
        $formfields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formfields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now Logged in');
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
