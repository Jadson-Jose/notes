<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function logout()
    {
        echo "Logout";
    }

    public function loginSubmit(Request $request)
    {
        // Form validation
        $request->validate([
            'text_username'=> 'required',
            'text_password' => 'required'
        ]);

        // Get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        echo 'OK!';
    }
}
