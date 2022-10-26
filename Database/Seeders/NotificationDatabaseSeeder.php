<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NotificationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        DB::table('notification_channels')->insert([
                ['name' => 'WhatsApp', 'state' => 0],
                ['name' => 'Email', 'state' => 1],
                ['name' => 'App', 'state' => 1]
        ]);

        DB::table('notification_modules')->insert([
                ['name' => 'Compra y Venta'],
                ['name' => 'Servicio']
        ]);

        DB::table('notification_module_actions')->insert([
            [
                'notification_module_id' => 1,
                'name' => 'Action 1',
                'titletext' => 'Generic title text Action 1',
                'bodytext' => 'Generic body text Action 1',
                'urltext' => 'Generic url text Action 1'
            ],
            [
                'notification_module_id' => 1,
                'name' => 'Action 2',
                'titletext' => 'Generic title text Action 29',
                'bodytext' => 'Generic body text Action 29',
                'urltext' => 'Generic url text Action 29'
            ],
            [
                'notification_module_id' => 1,
                'name' => 'Action 3',
                'titletext' => 'Generic title text Action 3',
                'bodytext' => 'Generic body text Action 3',
                'urltext' => 'Generic url text Action 3'
            ],
            [
                'notification_module_id' => 1,
                'name' => 'Action 4',
                'titletext' => 'Generic title text Action 4',
                'bodytext' => 'Generic body text Action 4',
                'urltext' => 'Generic url text Action 4'
            ],
            [
                'notification_module_id' => 2,
                'name' => 'Action 1',
                'titletext' => 'Generic title text Action 1',
                'bodytext' => 'Generic body text Action 1',
                'urltext' => 'Generic url text Action 1'
            ],
            [
                'notification_module_id' => 2,
                'name' => 'Action 2',
                'titletext' => 'Generic title text Action 2',
                'bodytext' => 'Generic body text Action 2',
                'urltext' => 'Generic url text Action 2'
            ],
            [
                'notification_module_id' => 2,
                'name' => 'Action 3',
                'titletext' => 'Generic title text Action 3',
                'bodytext' => 'Generic body text Action 3',
                'urltext' => 'Generic url text Action 3'
            ]
        ]);

    }
}
