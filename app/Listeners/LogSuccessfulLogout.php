<?php

namespace App\Listeners;

use App\LoginHist;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogout
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
     * @param  Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if (LoginHist::where('user_id', $event->user->user_id)->exists()) {
            LoginHist::where('user_id', $event->user->user_id)->latest()->update([
                'LOGOUT_DTM' => now()->format('YmdHis'),
            ]);
        }
    }
}
