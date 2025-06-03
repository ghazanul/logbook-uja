<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');


        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            $request->session()->regenerate();

            $season = Season::all()->last()->name;
            return redirect('/' . $season . '/home');
        } else {
            return redirect('/')->withErrors([
                'auth' => 'Username atau password salah',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
