<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;


class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // Form validation
        $request->validate(
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:16'
            ],

            [
                'text_username.required' => 'O username é obrigatório.',
                'text_username.email' => 'Username deve ser um email válido.',
                'text_password.required' => 'A password é obrigatória.',
                'text_password.min' => 'A password deve ter pelo menos :min caracteres.',
                'text_password.max' => 'A password deve ter no máximo :max carateres.'
            ]
        );

        // Get user input
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // check if user exists
        $user = User::where('username', $username)->where('deleted_at', NULL)->first();
        if (!$user) {
            return redirect()->back()->withInput()->with(
                'LoginError',
                'Username ou password incorretos.'
            );
        }

        //  check if password is correct
        if (!password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with(
                'LoginError',
                'Username ou password incorretos.'
            );
        }

        // update last login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->usename
            ]
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        // Logout from the aplication
        session()->forget('user');
        return redirect()->to('/login');
    }
}
