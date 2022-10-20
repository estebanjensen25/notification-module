<?php

use Illuminate\Support\Facades\Auth;
use Modules\Notification\Http\Controllers\NotificationController;
use Modules\Notification\Events\EventNotification;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::prefix('notification')->group(function() {
    Route::get('/', 'NotificationController@index');
});
*/

Route::group(['prefix' => 'notification', 'middleware' => 'auth'], function() {
    Route::get('/setting', [NotificationController::class, 'setting'])->name('notification.setting');
    Route::post('/setting/load', [NotificationController::class, 'load'])->name('notification.setting.load');
    Route::get('/dashboard', [NotificationController::class, 'dashboard'])->name('notification.dashboard');
    Route::get('/dashboard/{timezone}/getnotifications/{type}', [NotificationController::class, 'getnotifications'])->name('notification.dashboard.getnotifications');
    Route::get('/dashboard/{notification_id}/readmore', [NotificationController::class, 'readmore'])->name('notification.dashboard.readmore');
    Route::delete('/dashboard/{notification_id}/delete', [NotificationController::class, 'delete'])->name('notification.dashboard.delete');
});

Route::get('/testEvent', function () {  
    $data['transmitter_establishment_id'] = session()->get('establishment_id');
    $data['transmitter_user_id'] = Auth::user()->id;
    $data['recipient_users_id'] = [1]; 
    $data['recipient_establishment_id'] = 1; 
    $data['module_action_id'] = 5;
    event(new EventNotification($data));
});

