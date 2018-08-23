<?php

namespace Dhcd\Notification\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\Notification\App\Repositories\NotificationRepository;
use Dhcd\Member\App\Repositories\GroupRepository;

use Dhcd\Notification\App\Models\Notification;
use Dhcd\Notification\App\Models\LogSent;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DateTime;

use Dhcd\Member\App\Models\Member;
use Dhcd\Member\App\Models\Group;
class NotificationController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(NotificationRepository $notificationRepository,GroupRepository $groupRepository)
    {
        parent::__construct();
        $this->notification = $notificationRepository;
        $this->group = $groupRepository;
    }

    public function manage()
    {
        return view('DHCD-NOTIFICATION::modules.notification.notification.manage');
    }

    public function create()
    {
        return view('DHCD-NOTIFICATION::modules.notification.notification.create');
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

                return redirect()->route('dhcd.notification.notification.manage')->with('success', trans('dhcd-notification::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.notification.notification.manage')->with('error', trans('dhcd-notification::language.messages.error.create'));
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
                return redirect()->route('dhcd.notification.notification.manage')->with('error', trans('dhcd-notification::language.messages.error.update'));    
            }
            $data = [
                'notification' => $notification
            ];
            return view('DHCD-NOTIFICATION::modules.notification.notification.edit', $data);
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
            $notification->content = $request->input('content');

            if ($notification->save()) {

                activity('notification')
                    ->performedOn($notification)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update notification - notification_id: :properties.notification_id, name: :properties.name');

                return redirect()->route('dhcd.notification.notification.manage')->with('success', trans('dhcd-notification::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.notification.notification.show', ['notification_id' => $request->input('notification_id')])->with('error', trans('dhcd-notification::language.messages.error.update'));
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
                $confirm_route = route('dhcd.notification.notification.delete', ['notification_id' => $request->input('notification_id')]);
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
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

            return redirect()->route('dhcd.notification.notification.manage')->with('success', trans('dhcd-notification::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.notification.notification.manage')->with('error', trans('dhcd-notification::language.messages.error.delete'));
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
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_table', compact('error', 'model', 'confirm_route'));
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
                if ($this->user->canAccess('dhcd.notification.notification.log')) {
                    $actions .= '<a href=' . route('dhcd.notification.notification.log', ['type' => 'notification', 'id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log notification"></i></a>';
                }
                if ($this->user->canAccess('dhcd.notification.notification.show')) {
                    $actions .= '<a href=' . route('dhcd.notification.notification.show', ['notification_id' => $notifications->notification_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update notification"></i></a>';
                }
                if ($this->user->canAccess('dhcd.notification.notification.confirm-delete')) {        
                    $actions .= '<a href=' . route('dhcd.notification.notification.confirm-delete', ['notification_id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete notification"></i></a>';
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
                // if ($this->user->canAccess('dhcd.notification.notification.confirm-sent')) {
                    $sent .= '<a href=' . route('dhcd.notification.notification.confirm-sent', ['notification_id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#sent_notification"><i class="livicon" data-name="send" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="sent notification"></i></a>';
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
                $groups = $this->group->all();
                $confirm_route = route('dhcd.notification.notification.sent', ['notification_id' => $request->input('notification_id')]);
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_sent_notification', compact('type','error', 'model', 'confirm_route','groups'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_sent_notification', compact('type','error', 'model', 'confirm_route','groups'));
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
            $time_sent = $request->input('time_sent');
            if($time_sent != null || $time_sent != ''){
                $date = new DateTime($request->input('time_sent'));
                $time_sent = $date->format('Y-m-d H:i:s');
            }
            
            $log_sent = new LogSent();
            $log_sent->notification_id = $request->input('notification_id');
            $log_sent->group_id = $request->input('group_id');
            $log_sent->create_by = $this->user->email;
            $log_sent->time_sent = $time_sent;
            $log_sent->created_at = new DateTime();
            $log_sent->updated_at = new DateTime();
            if ($log_sent->save()) {

                activity('notification')
                    ->performedOn($notification)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Sent notification - notification_id: :properties.notification_id, name: :properties.name');

                return redirect()->route('dhcd.notification.notification.manage')->with('success', trans('dhcd-notification::language.messages.success.sent'));
            } else {
                return redirect()->route('dhcd.notification.notification.manage')->with('error', trans('dhcd-notification::language.messages.error.sent'));
            }
        } else {
            return $validator->messages();
        }
    }

}
