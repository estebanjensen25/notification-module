<?php

namespace Modules\Notification\Entities;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    protected $table = 'notification_notifications';
    protected $guarded = ['id'];    
}
