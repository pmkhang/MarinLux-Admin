<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage()
    {
        if (Auth::check()) {
            return redirect('/');
        } else {
            return view('auth.login');
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->level == 3) {
                Auth::logout();
                return redirect()->back()->with('error', 'Access denied');
            }

            return redirect('/');
        } else {
            return redirect()->back()->with('error', 'Email or password is incorrect');
        }
    }
}
