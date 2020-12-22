<?php

namespace App\Mail;

use App\CommCd;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $email = $this->user->EMAIL;
        $token = $this->getToken($email);
        $url = url('/reset-password') . '?token=' . $token . '&email=' . urlencode($email);

        return $this->markdown('emails.new_user_info', [
            'user' => $this->user,
            'introMessage' => $this->introMessage,
            'roles' => CommCd::where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $this->user->ROLE_CD))->get(),
            'approvals' => CommCd::where('COMM1_CD', 'B10')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $this->user->APPR_CD))->get(),
            'url' => $url,
        ]);
    }

    private function getToken($email)
    {
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => Str::random(60), //change 60 to any length you want
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')->where('email', $email)->first()->token;

        return $tokenData;
    }
}
