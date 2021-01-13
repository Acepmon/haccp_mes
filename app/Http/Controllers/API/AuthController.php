<?php

namespace App\Http\Controllers\API;

use App\Events\UserPasswordUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'user_id' => 'required|max:15|unique:USER,user_id',
            'user_pw'  => 'required|min:3',
            'user_nm'  => 'nullable|max:20',
            'email'  => 'nullable|email|max:50',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = new User();
        $user->user_id = $request->user_id;
        $user->user_pw = Hash::make($request->user_pw);
        $user->user_nm = $request->user_nm;
        $user->email = $request->email;
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        $credentials = [
            'user_id' => $request->input('user_id'),
            'password' => $request->input('user_pw'),
        ];

        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json([
                'status' => 'success',
                'result' => new UserResource(Auth::user()),
            ], 200)->header('Authorization', $token);
        }

        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::id());

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    private function guard()
    {
        return Auth::guard();
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|string|email|exists:USER,EMAIL',
            'password' => 'required|string|confirmed'
        ]);

        $token = $request->input('token');
        $email = $request->input('email');
        $password = $request->input('password');
        $tokenData = DB::table('password_resets')->where('token', $token)->first();

        if (!$tokenData) {
            return response()->json([
                'success' => false,
                'message' => __('Invalid token')
            ], 422);
        }

        $user = User::where('email', $email)->first();
        $user->USER_PW = Hash::make($password);
        $user->save();

        event(new UserPasswordUpdated($user, $password));

        DB::table('password_resets')->where('email', $email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset',
        ]);
    }

    public function notifications(Request $request)
    {
        $user = User::find(Auth::id());
        $items = $user->notifications->sortBy('created_at');

        return NotificationResource::collection($items);
    }

    public function unreadNotifications(Request $request)
    {
        $user = User::find(Auth::id());
        $items = $user->unreadNotifications->sortBy('created_at');

        return NotificationResource::collection($items);
    }

    public function readAllNotifications(Request $request)
    {
        $user = User::find(Auth::id());

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function deleteNotifications(Request $request)
    {
        $user = User::find(Auth::id());

        $user->notifications()->delete();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
