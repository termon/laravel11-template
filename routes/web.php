<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome')->name('home');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');


// auth group
Route::middleware('auth')->group(function () {
    Route::post("/logout", [UserController::class, "logout"])->name("logout");
});


// guest group
Route::middleware('guest')->group(function () {
    Route::get("/register", [UserController::class, "create"])->name("register");
    Route::post("/register", [UserController::class, "store"]);

    Route::get("/login", [UserController::class, "login"])->name("login");
    Route::post("/login", [UserController::class, "authenticate"]);

    Route::get("/auth/azure/login", [UserController::class, 'azureLogin'])->name('azure.login');
    Route::get("/auth/azure/callback", [UserController::class, 'azureCallback'])->name('azure.callback');
});
