<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $throttleKey = $request->email . '|' . $request->ip();
    
        // Check if the user is throttled
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in $seconds seconds.",
            ]);
        }
    
        $user = User::where('email', $credentials['email'])->first();
    
        if ($user && Hash::check($credentials['password'] . $user->salt, $user->password)) {
            Auth::login($user);
            RateLimiter::clear($throttleKey); // Clear attempts on successful login
            return redirect()->intended(route('todo'))->with('success', 'Login successful!');
        }
    
        RateLimiter::hit($throttleKey, 60); // Record a failed attempt (expires in 60 seconds)
    
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    
    }

    public function logout()
    {
        Auth::logout(); // Log the user out
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Ensure this points to your registration Blade file
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
}
