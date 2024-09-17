<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.register', ['user' => new User]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            "name" => 'required',
            "email" => ['required', 'email', 'unique:users'],
            "password" => ['required', 'confirmed', 'min:6']
        ]);

        // create user
        $user = User::create($credentials);

        // log user in
        Auth::login($user);

        return redirect()->route("home")
            ->with('success', "Successfully registered");
    }

    /**
     * Show the form for login.
     */
    public function login()
    {
        return view('user.login', ['user' => new User]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route("home")
                ->with('success', "Logged in Successfully");
        }
        return redirect()->back()->withErrors(
            [
                'email' => 'Invalid credentials',
                'password' => 'Invalid credentials'
            ]
        );
        // return redirect()->route("user.login")->with('error', "Invalid Credentials");
    }

    public function logout(Request $request)
    {
        // remove the authentication information from the user's session
        auth()->logout();
        // invalidate the user session
        $request->session()->invalidate();
        // regenerate the CSRF token
        $request->session()->regenerateToken();

        return redirect()->route("home")
            ->with('success', "Successfully logged out");
    }
}
