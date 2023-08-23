<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($user = User::attempt($credentials['username'], $credentials['password'])) {
            $request->session()->put('user', $user);
            $request->session()->put('authenticated', true);
            // Authentication passed
            return redirect()->intended('/');
        } else {
            // Authentication failed
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('authenticated');
        return redirect('/login');
    }
}
