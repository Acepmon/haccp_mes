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

    public $worker;
    public $title;
    public $message;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Worker $worker)
    {
        $this->worker = $worker;
        $this->title = 'Health check alert';
        $this->message = 'Worker ' . $this->worker->EMP_NM . ' health check is due at ' . now()->parse($this->worker->HEALTH_CHK_DT)->format('Y-m-d') . '.';
        $this->url = url('/information/worker?emp_id=' . $this->worker->EMP_ID);
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
                    ->line($this->message)
                    ->action('View worker record', $this->url);
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
            'url' => $this->url,
            'data' => new WorkerResource($this->worker)
        ];
    }
}
