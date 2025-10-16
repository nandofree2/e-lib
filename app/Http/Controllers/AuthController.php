<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $code = Str::random(6);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 3, // default customer
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Please login to verify your account.'
        ]);
    }

    public function sendVerificationCode(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in.');
        }

        $code = rand(100000, 999999);
        $user->verification_code = $code;
        $user->save();

        Mail::raw("Your verification code: $code", function ($msg) use ($user) {
            $msg->to($user->email)->subject('Email Verification');
        });

        return response()->json(['success' => true, 'message' => 'Verification code sent.']);
    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'You must be logged in.');
        }

        if ($request->code == $user->verification_code) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->save();
            return redirect('/')->with('success', 'Email verified successfully!');
        }

        return back()->with('error', 'Wrong verification code.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            return redirect()->route('home');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out.');
    }
}
