<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    protected $redirectTo = '/todo';

public function login(LoginRequest $request)
{
    $credentials = $request->only('email', 'password');
    $user = User::where('email', $credentials['email'])->first();

    $throttleKey = strtolower($request->input('email')).'|'.$request->ip();

    if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
        $seconds = RateLimiter::availableIn($throttleKey);
        return back()->withErrors([
            'email' => "Too many login attempts. Please try again in $seconds seconds.",
        ]);
    }

    if ($user && Hash::check($credentials['password'] . $user->salt, $user->password)) {
        Auth::login($user);
        RateLimiter::clear($throttleKey);
        return redirect()->intended($this->redirectTo)->with('success', 'Welcome!');
    }

    RateLimiter::hit($throttleKey, 60);

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}