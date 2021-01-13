<?php

namespace App\Listeners;

use App\Events\CcpLimitDnExceeded;
use App\Mail\CcpLimitReached;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendCcpLimitDnNotification
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
     * @param  CcpLimitDnExceeded  $event
     * @return void
     */
    public function handle(CcpLimitDnExceeded $event)
    {
        $to = [
            ['email' => env('ADMIN_EMAIL'), 'name' => 'Administrator', 'subject' => 'CCP Limit reached', 'from' => env('MAIL_FROM_ADDRESS')]
        ];

        if (false) {
            Mail::to($to)->queue(new CcpLimitReached($event->ccpLimit));
        }
    }
}
