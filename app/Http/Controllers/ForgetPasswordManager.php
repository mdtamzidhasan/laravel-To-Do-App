<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgetPasswordManager extends Controller
{
    public function forgetPassword()
    {
        return view('auth.forget-password');
    }


    public function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);


        Mail::send('email.forget-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->route('forget.password')->with('success', 'We have emailed your password reset link!');

        
    }
    



    public function resetPassword($token)
    {

        return view('auth.new-password', ['token' => $token]);
    }

    public function resetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required'
        ]);

        $passwordReset = DB::table('password_resets')->where([
            ['token', $request->token],
            ['email', $request->email],
        ])->first();

        if (!$passwordReset || Carbon::parse($passwordReset->created_at)->addMinutes(120)->isPast()) {
            return redirect()->route('reset.password')->with('error', 'This password reset token is invalid or has expired.');
        }
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Your password has been reset successfully!');
    }
}