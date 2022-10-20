<?php

namespace Modules\Notification\Listeners;

use Modules\Notification\Events\EventNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Entities\User;
use Modules\Notification\Notifications\NotificationAlliotec;

class ListenerNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param EventNotification $event
     * @return void
     */
    public function handle(EventNotification $event)
    {
        foreach($event->data['recipient_users_id'] as $recipientuser)
        {
            $channels = DB::table('notification_module_action_user')
                            ->where(['user_id' => $recipientuser, 'notification_module_action_id' => $event->data['module_action_id']])
                            ->pluck('notification_channel_id')
                            ->toArray();
            $user = User::find($recipientuser);
            
            if (isset($channels))
            {
                $event->data['channels'] = $channels;
                $user->notify(new NotificationAlliotec($event->data));
            }            
        }
    }
}
