<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Http\Resources\AppUserResource;

class SanctumController extends Controller
{
    public function token(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'user_pw' => 'required',
            'user_token' => 'nullable|string', // fcm token
        ]);

        $user = User::where('user_id', $request->input('user_id'))->first();

        if (!$user || !Hash::check($request->input('user_pw'), $user->USER_PW)) {
            return $this->jsonResponse([
                'status' => 'error',
                'msg' => '사용자 ID나 비밀번호가 틀렸습니다.'
            ], 422);
        }

        $user->DEVICE_TOKEN = $request->input('user_token');
        $user->save();

        $token = $user->createToken($user->USER_ID)->plainTextToken;

        return $this->jsonResponse([
            'status' => 'success',
            'msg' => '',
            'data' => [
                'token' => $token,
                'comp_id' => '681-86-00273',
                'user' => new AppUserResource($user)
            ]
        ], 200);
    }
}
