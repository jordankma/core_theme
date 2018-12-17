<?php

namespace Vne\Notification\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Vne\Notification\App\Repositories\NotificationRepository;

use Vne\Notification\App\Models\Notification;
use Vne\Notification\App\Models\LogSent;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DateTime;

use Vne\Member\App\Models\Member;
use Vne\Member\App\Models\Group;
class NotificationController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $api_key_firebase = "AIzaSyAq9otIY5XLE7dB-fa1u08AJgfxjuO1nxQ";

    public function __construct(NotificationRepository $notificationRepository)
    {
        parent::__construct();
        $this->notification = $notificationRepository;
    }

    public function manage()
    {
        return view('VNE-NOTIFICATION::modules.notification.notification.manage');
    }

    public function create()
    {
        return view('VNE-NOTIFICATION::modules.notification.notification.create');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:200',
            'content' => 'required|min:1|max:400'
        ], $this->messages);
        if (!$validator->fails()) {
            $notifications = new Notification();
            $notifications->name = $request->input('name');
            $notifications->alias = self::stripUnicode($request->input('name'));
            $notifications->content = $request->input('content');
            $notifications->created_at = new DateTime();
            $notifications->updated_at = new DateTime();
            if ($notifications->save()) {

                activity('notification')
                    ->performedOn($notifications)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add template notification - name: :properties.name, notification_id: ' . $notifications->notification_id);

                return redirect()->route('vne.notification.notification.manage')->with('success', trans('vne-notification::language.messages.success.create'));
            } else {
                return redirect()->route('vne.notification.notification.manage')->with('error', trans('vne-notification::language.messages.error.create'));
            }
        }
        else {
            return $validator->messages();
        }
    }

    public function show(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $notification_id = $request->input('notification_id');
            $notification = $this->notification->find($notification_id);
            if(null==$notification){
                return redirect()->route('vne.notification.notification.manage')->with('error', trans('vne-notification::language.messages.error.update'));    
            }
            $data = [
                'notification' => $notification
            ];
            return view('VNE-NOTIFICATION::modules.notification.notification.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric',
            'name' => 'required|min:1|max:200',
            'content' => 'required|min:1|max:400'
        ], $this->messages);
        if (!$validator->fails()) {
            $notification_id = $request->input('notification_id');
            $notification = $this->notification->find($notification_id);
            $notification->name = $request->input('name');
            $notifications->alias = self::stripUnicode($request->input('name'));
            $notification->content = $request->input('content');

            if ($notification->save()) {

                activity('notification')
                    ->performedOn($notification)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update notification - notification_id: :properties.notification_id, name: :properties.name');

                return redirect()->route('vne.notification.notification.manage')->with('success', trans('vne-notification::language.messages.success.update'));
            } else {
                return redirect()->route('vne.notification.notification.show', ['notification_id' => $request->input('notification_id')])->with('error', trans('dhcd-notification::language.messages.error.update'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'notification';
        $type = "delete";
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.notification.notification.delete', ['notification_id' => $request->input('notification_id')]);
                return view('VNE-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $notification_id = $request->input('notification_id');
        $notification = $this->notification->find($notification_id);

        if (null != $notification) {
            $this->notification->delete($notification_id);

            activity('notification')
                ->performedOn($notification)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete notification - notification_id: :properties.notification_id, name: ' . $notification->name);

            return redirect()->route('vne.notification.notification.manage')->with('success', trans('vne-notification::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.notification.notification.manage')->with('error', trans('vne-notification::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'notification';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('VNE-NOTIFICATION::modules.notification.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NOTIFICATION::modules.notification.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->notification->findAll())
            ->addColumn('actions', function ($notifications) {
                $actions = '';
                if ($this->user->canAccess('vne.notification.notification.log')) {
                    $actions .= '<a href=' . route('vne.notification.notification.log', ['type' => 'notification', 'id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log notification"></i></a>';
                }
                if ($this->user->canAccess('vne.notification.notification.show')) {
                    $actions .= '<a href=' . route('vne.notification.notification.show', ['notification_id' => $notifications->notification_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update notification"></i></a>';
                }
                if ($this->user->canAccess('vne.notification.notification.confirm-delete')) {        
                    $actions .= '<a href=' . route('vne.notification.notification.confirm-delete', ['notification_id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete notification"></i></a>';
                }
                return $actions;
            })
            ->addColumn('created_at', function ($notifications) {
                $date = new DateTime($notifications->created_at);
                $created_at = date_format($date, 'd-m-Y');
                return $created_at;   
            })
            ->addColumn('sent', function ($notifications) {
                $sent = '';
                // if ($this->user->canAccess('vne.notification.notification.confirm-sent')) {
                    $sent .= '<a href=' . route('vne.notification.notification.confirm-sent', ['notification_id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#sent_notification"><i class="livicon" data-name="send" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="sent notification"></i></a>';
                // }
                return $sent;   
            })
            ->addIndexColumn()
            ->rawColumns(['actions','sent','created_at'])
            ->make();
    }

    //sent notification

    public function getModalSent(Request $request) {
        $model = 'notification';
        $type = "sent";
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.notification.notification.sent', ['notification_id' => $request->input('notification_id')]);
                return view('VNE-NOTIFICATION::modules.notification.modal.modal_sent_notification', compact('type','error', 'model', 'confirm_route','groups'));
            } catch (GroupNotFoundException $e) {
                return view('VNE-NOTIFICATION::modules.notification.modal.modal_sent_notification', compact('type','error', 'model', 'confirm_route','groups'));
            }
        } else {
            return $validator->messages();
        }    
    }
    public function sent(Request $request) {
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $notification_id = $request->input('notification_id');
            $notification = $this->notification->find($notification_id);
            // $time_sent = $request->input('time_sent');
            // if($time_sent != null || $time_sent != ''){
            //     $date = new DateTime($request->input('time_sent'));
            //     $time_sent = $date->format('Y-m-d H:i:s');
            // }
            $log_sent = new LogSent();
            $log_sent->notification_id = $request->input('notification_id');
            $log_sent->create_by = $this->user->email;
            // $log_sent->time_sent = $time_sent;
            $log_sent->created_at = new DateTime();
            $log_sent->updated_at = new DateTime();
            if ($log_sent->save()) {
                $message = [
                    'title' => $notification->name,
                    'body' => $notification->content
                ];
                $this->sendGCM( $message );
                activity('notification')
                    ->performedOn($notification)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Sent notification - notification_id: :properties.notification_id, name: :properties.name');
                    
                return redirect()->route('vne.notification.notification.manage')->with('success', trans('vne-notification::language.messages.success.sent'));
            } else {
                return redirect()->route('vne.notification.notification.manage')->with('error', trans('vne-notification::language.messages.error.sent'));
            }
        } else {
            return $validator->messages();
        }
    }
    private function sendGCM($message=null) {
        $list_topic = array('global','global1','global2','global3','global4','global5','global6','global7','global8','global9');
        if($message==null){
            $msg = array(
                'title' => 'Thông báo',
                'body'  => 'Nội dung thông báo'
            );
        } else {
            $msg = $message;  
        }
        foreach ($list_topic as $key => $value) {
            $this->actionSendGCM($value,$msg);
        }
    }
    private function actionSendGCM($topic_name,$msg) {
        $fields = array (
          'to' => '/topics/'.$topic_name,
          'notification' => $msg
        );
        $headers = array
        (
            'Authorization: key=' . $this->api_key_firebase,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server    
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec( $ch );
        curl_close( $ch );
        #Echo Result Of FireBase Server
    }

    public function notificationList(){
        $notifications = Notification::all();
        $list_notification = array();
        foreach ($notifications as $key => $value) {
            $list_notification[] = [
                'name' => $value->name,
                'content' => $value->content
            ];    
        } 
        return json_encode($list_notification);   
    }
}
