<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function auth(Request $request)
    {
        dd('asdasdsa');
        $this->validate($request,[
            'user_id' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt(['user_id' => $request['user_id'], 'password' => $request['password']])){
            return response([
                'success' => true,
                'result' => Auth::user()
            ]);
        }

        return response([
            'success' => false,
            'result' => 'Authentication failed'
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        return response([
            'success' => true,
            'result' => $user
        ]);
    }

    public function username()
    {
        return 'USER_ID';
    }
}
