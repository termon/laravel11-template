<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

    // --------------------- OAuth Routes (Azure) ------------------------
    public function azureLogin()
    {

        return Socialite::driver('azure')->redirect();
    }

    public function azureCallback()
    {
        $azureUser = Socialite::driver('azure')->user();
        $givenName = $azureUser->user["givenName"] ?? "Anon";
        $surname = $azureUser->user["surname"] ?? "Anon";

        $user = User::updateOrCreate([
            'azure_id' => $azureUser->id,
        ], [
            'name' => $azureUser->name ?? $azureUser->nickname,
            'email' => $azureUser->email,
            'avatar' => $azureUser->avatar ?? "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBVcGxvYWRlZCB0bzogU1ZHIFJlcG8sIHd3dy5zdmdyZXBvLmNvbSwgR2VuZXJhdG9yOiBTVkcgUmVwbyBNaXhlciBUb29scyAtLT4NCjxzdmcgZmlsbD0iIzAwMDAwMCIgaGVpZ2h0PSI4MDBweCIgd2lkdGg9IjgwMHB4IiB2ZXJzaW9uPSIxLjEiIGlkPSJMYXllcl8xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiANCgkgdmlld0JveD0iMCAwIDUxMiA1MTIiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxjaXJjbGUgY3g9IjI1NiIgY3k9IjExNC41MjYiIHI9IjExNC41MjYiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTI1NiwyNTZjLTExMS42MTksMC0yMDIuMTA1LDkwLjQ4Ny0yMDIuMTA1LDIwMi4xMDVjMCwyOS43NjUsMjQuMTMsNTMuODk1LDUzLjg5NSw1My44OTVoMjk2LjQyMQ0KCQkJYzI5Ljc2NSwwLDUzLjg5NS0yNC4xMyw1My44OTUtNTMuODk1QzQ1OC4xMDUsMzQ2LjQ4NywzNjcuNjE5LDI1NiwyNTYsMjU2eiIvPg0KCTwvZz4NCjwvZz4NCjwvc3ZnPg==",
            'azure_token' => $azureUser->token,
            'azure_refresh_token' => $azureUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
