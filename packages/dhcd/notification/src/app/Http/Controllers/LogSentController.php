<?php

namespace Dhcd\Notification\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\Notification\App\Repositories\NotificationRepository;
use Dhcd\Notification\App\Repositories\LogSentRepository;


use Dhcd\Notification\App\Models\Notification;
use Dhcd\Notification\App\Models\LogSent;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DateTime;
// use Curl\Curl;

class LogSentController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(LogSentRepository $logSentRepository)
    {
        parent::__construct();
        $this->log_sent = $logSentRepository;
    }

    public function manage()
    {
        return view('DHCD-NOTIFICATION::modules.notification.log-sent.manage');
    }
    
    public function getModalDelete(Request $request)
    {
        $model = 'log_sent';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'log_sent_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.notification.log-sent.delete', ['log_sent_id' => $request->input('log_sent_id')]);
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $log_sent_id = $request->input('log_sent_id');
        $log_sent = $this->log_sent->find($log_sent_id);

        if (null != $log_sent) {
            $this->log_sent->delete($log_sent_id);

            activity('log_sent')
                ->performedOn($log_sent)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete log_sent - log_sent_id: :properties.log_sent_id, name: ' . $log_sent->name);

            return redirect()->route('dhcd.notification.log-sent.manage')->with('success', trans('dhcd-notification::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.notification.log-sent.manage')->with('error', trans('dhcd-notification::language.messages.error.delete'));
        }
    }

    //Table Data to index page
    public function data()
    {
        $log_sents = LogSent::orderBy('log_sent_id', 'desc')->with('notification')->get();
        return Datatables::of($log_sents)
            ->addIndexColumn()
            ->addColumn('actions', function ($log_sents) {
                $actions = '<a href=' . route('dhcd.notification.log-sent.confirm-delete', ['log_sent_id' => $log_sents->log_sent_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete log_sent"></i></a>';
                return $actions;
            })
            ->addColumn('created_at', function ($log_sents) {
                $date = new DateTime($log_sents->created_at);
                $created_at = date_format($date, 'd-m-Y');
                return $created_at;   
            })
            ->addColumn('notification_id', function ($log_sents) {
                $notification_id = htmlspecialchars($log_sents->notification->name);
                return $notification_id;   
            })
            ->rawColumns(['actions','created_at','notification_id'])
            ->make();
    }
}
