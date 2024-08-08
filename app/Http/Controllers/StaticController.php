<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    /**
     * Display the login page
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login', [
            "title" => "Login",
            "active" => "login"
        ]);
    }

    /**
     * Display the register page
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register', [
            "title" => "Register",
            "active" => "register"
        ]);
    }
}
