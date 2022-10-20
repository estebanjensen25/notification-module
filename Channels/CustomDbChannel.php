<?php
namespace Modules\Notification\Channels;
use Illuminate\Notifications\Notification;

class CustomDbChannel {
  public function send($notifiable, Notification $notification)
  {
    $data = $notification->toDatabase($notifiable);
    return $notifiable->routeNotificationFor('database')->create([
        'id' => $notification->id,
        //inicio customize here
        'transmitter_user_id' => $data['transmitter_user_id'],
        'transmitter_establishment_id' => $data['transmitter_establishment_id'],
        //fin customize here
        'type' => get_class($notification),
        'data' => $data,
        'read_at' => null,
    ]);
  }
}