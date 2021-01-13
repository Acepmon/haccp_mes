<?php

namespace App\Notifications;

use App\CcpData;
use App\CcpEscData;
use App\Http\Resources\CcpEscDataResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CcpLimitReached extends Notification
{
    use Queueable;

    public $ccpEscData;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CcpEscData $ccpEscData)
    {
        $this->ccpEscData = $ccpEscData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('emails.ccp_limit_reached', [
            'ccpEscData' => $this->ccpEscData
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return new CcpEscDataResource($this->ccpEscData);
    }
}
