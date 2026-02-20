<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthManager extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            // Authentication logic here (e.g., using Auth facade)
    
            $credentials = $request->only('email', 'password');
            if(Auth::attempt($credentials)) {
                return redirect()->intended(route(('home')));
            }
            return redirect(route("login"))->with("Error", "Invalid Email or Password");
    }



    public function register()
    {
        return view('auth.register');
    }


    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if($user->save()) {
            return redirect(route("login"))->with("Success", "Account created successfully. Please login.");
        }
        return redirect(route("register"))->with("Error", "Failed to create account. Please try again.");
    }
}