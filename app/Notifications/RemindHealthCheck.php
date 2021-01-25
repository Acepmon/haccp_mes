<?php

namespace App\Notifications;

use App\Http\Resources\WorkerResource;
use App\Worker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RemindHealthCheck extends Notification
{
    use Queueable;

    public $workers;
    public $title;
    public $message;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($workers)
    {
        $chkDt = $workers->first()->HEALTH_CHK_DT;
        $names = $workers->pluck('EMP_NM')->toArray();
        $names = implode(',', $names);

        $this->workers = $workers; // a, b, c
        $this->title = '보건증 갱신 알림';
        $this->message = '작업자 이름: ' . $names . '님의 보건증 갱신일자는 다음과 같습니다.' . now()->parse($chkDt)->format('Y-m-d') . '.';
        $this->url = url('/information/worker');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject($this->title)
                    ->greeting('Hello ' . $notifiable->USER_NM)
                    ->line($this->message);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'msg' => $this->message,
            'time' => now()->format('Y-m-d H:i:s'),
            'icon' => '',
            'url' => $this->url
        ];
    }
}
