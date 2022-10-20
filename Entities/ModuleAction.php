<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notification\Entities\User;

class ModuleAction extends Model
{
    use HasFactory;

    protected $table = 'notification_module_actions';
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification_module_action_user','user_id','notification_module_action_id')->withpivot('notification_channel_id');
    }
    
}
