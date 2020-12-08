<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('application');
    }

    public function auth(Request $request)
    {
        $credentials = [
            'user_id' => $request->input('user_id'),
            'password' => $request->input('user_pw')
        ];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return response()->json([
                'success' => true,
                'message' => __('Authenticated!')
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => __('User ID or password is wrong!')
        ], 500);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->intended();
    }
}
