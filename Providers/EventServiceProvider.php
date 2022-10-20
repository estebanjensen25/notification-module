<?php

namespace Modules\Notification\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Notification\Events\EventBuyAndSell;
use Modules\Notification\Events\EventNotification;

/* Para carga de Menu  
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\DB;*/

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EventNotification::class => [
            \Modules\Notification\Listeners\ListenerNotification::class,
        ],
    ];

}
