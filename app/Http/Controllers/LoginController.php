<?php

namespace App\Http\Controllers;

use App\LoginHist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function monitor () {
        return view('application');
    }

    public function login () {
        return view('application');
    }

    public function resetPassword () {
        return view('application');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'USER_ID' => 'required',
            'password' => 'required'
        ]);

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
            'result' => __('사용자 ID 나 비밀번호가 틀렸습니다.')
        ]);
    }

    public function logout()
    {
        if (Auth::check() && LoginHist::where('USER_ID', Auth::user()->USER_ID)->exists()) {
            LoginHist::where('USER_ID', Auth::user()->USER_ID)->update([
                'LOGOUT_DTM' => now()->format('YmdHis'),
            ]);
        }

        Auth::logout();

        return response([
            'success' => true,
            'result' => __('Successfully logged out')
        ]);
    }
}
