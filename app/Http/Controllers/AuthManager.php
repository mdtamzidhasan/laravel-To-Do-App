<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OtpVerifyRequest;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;

class AuthManager extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function login()
    {
        if(Auth::check()) {
        return redirect()->route('home');
        }
    
        return view('auth.login');
    }

    public function loginPost(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember     = $request->boolean('remember');
        $credentials  = $request->only('email', 'password');

        
        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->with('Error', 'Invalid Email or Password.');
        }

        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        $this->otpService->generate($user);

        session([
            'otp_user_id'  => $user->id,
            'otp_remember' => $remember,
        ]);

        return redirect()->route('otp.verify.form')
            ->with('Success', "OTP পাঠানো হয়েছে {$user->email} এ। মেয়াদ ৫ মিনিট।");
    }

    // ─────────────────────────────────────────
    //  OTP VERIFY
    // ─────────────────────────────────────────

    public function showOtpForm(): View|RedirectResponse
    {

        if (! session('otp_user_id')) {
            return redirect()->route('login')
                ->with('Error', 'Session expired। আবার login করুন।');
        }

        return view('auth.otp-verify');
    }

    public function verifyOtp(OtpVerifyRequest $request): RedirectResponse
    {
        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('login')
                ->with('Error', 'Session expired। আবার login করুন।');
        }

        $user = User::findOrFail($userId);


        if (! $this->otpService->verify($user, $request->otp)) {
            return back()->with('Error', 'OTP ভুল অথবা expired। আবার চেষ্টা করুন।');
        }

        
        $remember = session('otp_remember', false);
        Auth::login($user, $remember);

        session()->forget(['otp_user_id', 'otp_remember']);
        $request->session()->regenerate();

        return redirect()->intended(route('home'))
            ->with('Success', 'Successfully logged in!');
    }

    public function resendOtp(): RedirectResponse
    {
        $userId = session('otp_user_id');

        if (! $userId) {
            return redirect()->route('login')
                ->with('Error', 'Session expired। আবার login করুন।');
        }

        $user = User::findOrFail($userId);
        $this->otpService->generate($user);

        return back()->with('Success', 'নতুন OTP পাঠানো হয়েছে।');
    }




    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route("login"))->with("Success", "Logged out successfully.");
    }



    public function register()
    {
        return view('auth.register');
    }


    public function registerPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed'
        ]);
        
        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password)
        ]);
        if($user->save()) {
            return redirect(route("login"))->with("Success", "Account created successfully. Please login.");
        }
        return redirect(route("register"))->with("Error", "Failed to create account. Please try again.");
    }
}