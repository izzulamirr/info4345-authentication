<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $salt = \Illuminate\Support\Str::random(16);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'salt' => $salt, // Store the generated salt
            'password' => bcrypt($validated['password']),
            'nickname' => $validated['nickname'] ?? null,
            'phone_no' => $validated['phone_no'] ?? null,
            'city' => $validated['city'] ?? null,
        ]);

        auth()->login($user);

        return redirect()->route('todo.index')->with('success', 'Registration successful!');
    }

    
    public function showRegistrationForm()
{
    return view('auth.register'); // Ensure this points to your registration Blade file
}



/**
     * Handle a registration request for the application.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/todo'; // Change this to '/todo' to redirect to the todo list after registration

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
   
}