<?php

namespace App\Notifications;

use App\CcpData;
use App\CcpEscData;
use App\Http\Resources\CcpEscDataResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class CcpLimitReached extends Notification implements ShouldQueue
{
    use Queueable;

    public $ccpEscData;
    public $device;
    public $data;
    public $msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(CcpEscData $ccpEscData)
    {
        $this->ccpEscData = $ccpEscData;
        $this->device = $this->ccpEscData->device ? $this->ccpEscData->device->COMM2_NM : $this->ccpEscData->DEVICE_ID;
        $this->data = $this->ccpEscData->ESC_DATA;
        $this->msg = '한계이탈장비: '.$this->device.'. 온도: ' . $this->data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database', 'mail', FcmChannel::class];
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
            ->subject('한계이탈 경고')
            ->markdown('emails.ccp_limit_reached', [
                'ccpEscData' => $this->ccpEscData
            ]
        );
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
            'title' => '한계이탈 경고',
            'msg' => $this->msg,
            'time' => now()->format('Y-m-d H:i:s'),
            'url' => null,
            // 'data' => new CcpEscDataResource($this->ccpEscData)
        ];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            // ->setData(['ccp_esc_data' => new CcpEscDataResource($this->ccpEscData)])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('한계이탈 경고')
                ->setBody('한계이탈장비: '.$this->device.'. 온도: ' . $this->data,))
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios')));
    }
}
