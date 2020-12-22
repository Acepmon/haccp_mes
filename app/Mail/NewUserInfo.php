<?php

namespace App\Mail;

use App\CommCd;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserInfo extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $introMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $introMessage = 'Thank you for registering')
    {
        $this->user = $user;
        $this->introMessage = $introMessage;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.new_user_info', [
            'user' => $this->user,
            'introMessage' => $this->introMessage,
            'roles' => CommCd::where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $this->user->ROLE_CD))->get(),
            'approvals' => CommCd::where('COMM1_CD', 'B10')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $this->user->APPR_CD))->get(),
        ]);
    }
}
