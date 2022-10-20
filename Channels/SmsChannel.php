<?php
namespace Modules\Notifications\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{

    public function __construct()
    {

    }


    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
    }

}