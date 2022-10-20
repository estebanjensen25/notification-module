<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Modules\Notification\Entities\Notification;

class User extends Model
{
    use Notifiable;
    protected $table = 'users';
    protected $guarded = ['id'];
    
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

}
