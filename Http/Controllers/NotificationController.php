<?php

namespace Modules\Notification\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Entities\User;
use Modules\Notification\Entities\Notification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function dashboard()
    {
        return view('notification::dashboard');
    }

    public function setting()
    {       
        if(request()->ajax()) 
        {     
            $this->actionuserwp = //Channel Whatsapp
            DB::table('notification_module_action_user')
            ->where(['user_id' => auth()->user()->id, 'notification_channel_id' => 1])
            ->pluck('notification_module_action_id')
            ->toArray();
            $this->actionuserem = //Channel Email
            DB::table('notification_module_action_user')
            ->where(['user_id'=> auth()->user()->id, 'notification_channel_id' => 2])
            ->pluck('notification_module_action_id')
            ->toArray();
            $this->actionuserph = //Channel Phone
            DB::table('notification_module_action_user')
            ->where(['user_id' => auth()->user()->id, 'notification_channel_id' => 3])
            ->pluck('notification_module_action_id')
            ->toArray();

            $module_action = DB::table('notification_modules AS nm')
                        ->join('notification_module_actions AS nma','nma.notification_module_id','=','nm.id')
                        ->select('nm.name as module', 'nma.id as module_action_id', 'nma.name as module_action')
                        ->get();
            return datatables()->of($module_action)
            ->addColumn('whatsapp', function($data)
            {
                if (in_array($data->module_action_id, $this->actionuserwp)){$checked = 'checked';}
                else{$checked = '';}
                $button = ''; 
                $button .= 
                '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" class="switch_channel custom-control-input" id="1_'.$data->module_action_id.'" '.$checked.' >
                    <label class="custom-control-label" for="1_'.$data->module_action_id.'"></label>
                </div>';
                return $button;
            })            
            ->addColumn('email', function($data)
            {
                if (in_array($data->module_action_id, $this->actionuserem)){$checked = 'checked';}
                else{$checked = '';}
                $button = ''; 
                $button .= 
                '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" class="switch_channel custom-control-input" id="2_'.$data->module_action_id.'" '.$checked.' >
                    <label class="custom-control-label" for="2_'.$data->module_action_id.'"></label>
                </div>';
                return $button;
            })       
            ->addColumn('phone', function($data)
            {
                if (in_array($data->module_action_id, $this->actionuserph)){$checked = 'checked';}
                else{$checked = '';}
                $button = ''; 
                $button .= 
                '<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                    <input type="checkbox" class="switch_channel custom-control-input" id="3_'.$data->module_action_id.'" '.$checked.' >
                    <label class="custom-control-label" for="3_'.$data->module_action_id.'"></label>
                </div>';
                return $button;
            })
            ->rawColumns(['whatsapp', 'email', 'phone'])
                ->addIndexColumn()
                ->make(true);
        } 
        $temporal = DB::table('notification_module_action_user')
        ->where('user_id', Auth::user()->id)
        ->select(DB::raw("CONCAT(notification_channel_id, '_',notification_module_action_id) AS id"), 'notification_channel_id as channel_id', 'notification_module_action_id as module_action_id')
        ->get()
        ->toArray();
        return view('notification::setting', compact('temporal'));
    }

    public function load(Request $request)
    {
        $user_id = $request->get('user_id');
        DB::table('notification_module_action_user')
            ->where('user_id', $user_id)
            ->delete();
        foreach( $request->get('temporal') as $register)
        {
            DB::table('notification_module_action_user')
            ->insert([
                'user_id' => $user_id,
                'notification_module_action_id' => $register['module_action_id'],
                'notification_channel_id' => $register['channel_id']
            ]);
        }

        return;
    }

    public function getnotifications($timezone, $type)
    {
        $this->fecha = date('Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
        $data = '';
        if ($type == 0) { $where = ['notifiable_id' => auth()->user()->id];}
        else { if ($type == 1 ) { $where = ['notifiable_id' => auth()->user()->id, 'read_at' => NULL];}}
        $notifications =  
         DB::table('notification_notifications as nn')
            ->join('establishment as e', 'e.id', '=', 'nn.transmitter_establishment_id')
            ->join('company as c', 'c.id', '=', 'e.company_id')
            ->where($where)
            ->select('nn.id as id', 'nn.notifiable_id', 'nn.data', 'nn.created_at as created_at', 'nn.read_at', 'e.name as establishment', 'c.company_name as company', 'c.id as company_id')
            ->orderby('created_at','desc')
            ->get();

        if ($notifications->count() == 0)
        {
            if ($type == 0) 
            {
                $data = '<div class="callout callout-info"><h5><i class="fas fa-info"></i> Nota:</h5>No posee notificaciones.</div>';
            }
            else
            { 
                if ($type == 1 ) {
                    $data = '<div class="callout callout-info"><h5><i class="fas fa-info"></i> Nota:</h5>No posee notificaciones sin leer.</div>';
                }
            }
        }
        else
        {
            foreach($notifications as $notification)
            { 
                $notitfication_data = json_decode($notification->data, true);
                if ($this->fecha <> date('Y-m-d',strtotime($notification->created_at)))
                {
                    $data.=
                    '<div class="time-label">
                        <span class="bg-red">'.date('Y-m-d', strtotime('-'.$timezone.' minutes',strtotime($notification->created_at))).'</span>
                    </div>';
                    $this->fecha = date('Y-m-d',strtotime($notification->created_at));
                }
                if ($notification->company_id == auth()->user()->company_id)
                {   $notification_origin = 'Notificación Interna de Establecimiento: <a href="#">'.$notification->establishment.'</a>';}
                else { $notification_origin = 'Notificación externa de Establecimiento: <a href="#">'.$notification->establishment.'</a> - Empresa: <a href="#">'.$notification->company.'</a>'; }

                $data.=
                '<div>
                    <i class="fas fa-comments bg-yellow"></i>
                    <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> '.date('H:i:s', strtotime('-'.$timezone.' minutes',strtotime($notification->created_at))).'</span>
                        <h3 class="timeline-header">'.$notification_origin.'</h3>
                        <div class="timeline-body">'.$notitfication_data["body"].'</div>';
    
                if ($notification->notifiable_id == auth()->user()->id)
                {                
                    if ($notification->read_at == NULL){$btn = 'btn-primary';}
                    else{$btn = 'btn-secondary';}  
                    $data.= 
                    '<div class="timeline-footer">
                        <a class="btn '.$btn.' btn-sm readmore" data-id='.$notification->id.' data-url='.$notitfication_data["url"].'>Leer</a>
                        <a class="btn btn-danger btn-sm delete" data-id='.$notification->id.'>Borrar</a>
                    </div>';
                }
    
                $data.=
                    '</div>
                </div>';
            }
    
            $data.='<div>
                <i class="fas fa-clock bg-gray"></i>
            </div>';

        }

        return $data;
    }

    public function readmore($notification_id)
    {
        $notification = Notification::find($notification_id);
        $notification->update(['read_at' => now()]);
        return;
    }

    public function delete($notification_id)
    {
        $notification = Notification::find($notification_id);
        $notification->delete();
        return;
    }
}
