<?php

namespace App\Http\Controllers;

use App\LoginHist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login () {
        return view('application');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('USER_ID', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response([
                'success' => true,
                'result' => Auth::user()
            ]);
        }

        // Authentication failed...
        return response([
            'success' => false,
            'result' => 'Authentication failed'
        ]);
    }

    public function logout()
    {
        if (LoginHist::where('USER_ID', Auth::user()->USER_ID)->exists()) {
            LoginHist::where('USER_ID', Auth::user()->USER_ID)->update([
                'LOGOUT_DTM' => now()->format('YmdHis'),
            ]);
        }

        Auth::logout();

        return redirect()->intended();
    }
}
