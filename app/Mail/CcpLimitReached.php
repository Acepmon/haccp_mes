<?php

namespace App\Mail;

use App\CcpLimit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CcpLimitReached extends Mailable
{
    use Queueable, SerializesModels;

    public $ccpLimit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CcpLimit $ccpLimit)
    {
        $this->ccpLimit = $ccpLimit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.ccp_limit_reached', [
            'ccpLimit' => $this->ccpLimit
        ]);
    }
}
