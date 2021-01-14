<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class SanctumController extends Controller
{
    public function token(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'user_pw' => 'required',
        ]);

        $user = User::where('user_id', $request->input('user_id'))->first();

        if (!$user || !Hash::check($request->input('user_pw'), $user->USER_PW)) {
            return response()->json([
                'status' => 'error',
                'msg' => '사용자 ID나 비밀번호가 틀렸습니다.'
            ], 422);
        }

        $token = $user->createToken($user->USER_ID)->plainTextToken;

        return response()->json([
            'status' => 'success',
            'msg' => '',
            'data' => [
                'token' => $token,
                'user' => new UserResource($user)
            ]
        ]);
    }
}
