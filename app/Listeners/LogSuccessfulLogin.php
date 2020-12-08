<?php

namespace App\Listeners;

use App\LoginHist;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        LoginHist::create([
            'USER_ID' => $event->user->USER_ID,
            'LOGIN_DTM' => now()->format('YmdHis'),
            'LOGOUT_DTM' => null,
            'IP_ADDR' => request()->ip(),
        ]);
    }
}
