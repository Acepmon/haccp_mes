<?php

namespace App\Listeners;

use App\CommCd;
use App\Events\CcpLimitUpExceeded;
use App\Notifications\CcpLimitReached;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendCcpLimitUpNotification
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
     * @param  CcpLimitUpExceeded  $event
     * @return void
     */
    public function handle(CcpLimitUpExceeded $event)
    {
        $ids = CommCd::where('COMM1_CD', 'AAA')->whereNotIn('COMM2_CD', ['$$'])->get()->pluck('COMM2_CD')->toArray();
        $users = User::whereIn('USER_ID', $ids)->get();

        Notification::send($users, new CcpLimitReached($event->ccpEscData));
    }
}
