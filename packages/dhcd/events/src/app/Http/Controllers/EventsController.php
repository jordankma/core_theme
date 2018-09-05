<?php

namespace Dhcd\Events\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Events\App\Repositories\EventsRepository;
use Dhcd\Events\App\Http\Requests\EventsRequest;
use Dhcd\Events\App\Models\Events;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Cache;

class EventsController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(EventsRepository $eventsRepository)
    {
        parent::__construct();
        $this->events = $eventsRepository;
    }

    public function manage()
    {
        return view('DHCD-EVENTS::modules.events.events.manage');
    }

    public function add(EventsRequest $request)
    {
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $event_content = $request->input('event_content');
        if(empty($start_time)) {
           return redirect()->route('dhcd.events.events.create')->with('error', trans('dhcd-events::language.messages.error.start_time'));
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($start_time); $i++){
                if(!$start_time[$i] || !$end_time[$i] || !$event_content[$i])
                {
                     return redirect()->route('dhcd.events.events.create')
                         ->with('start_time', $start_time)
                         ->with('end_time', $end_time)
                         ->with('content', $event_content)
                         ->with('error', trans('dhcd-events::language.messages.error.create'));
                }
                $result[$i] = [
                    "start_time" => $start_time[$i],
                    "end_time" => $end_time[$i],
                    "content" => $event_content[$i]
                ];
            }
            $event_detail = json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        $events = new Events($request->all());
        $events->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('date'))));
        $events->event_detail = $event_detail;
        $events->save();
        if ($events->event_id) {

            Cache::forget('api_events');

            activity('events')
                ->performedOn($events)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Event - name: :properties.name, event_id: ' . $events->event_id);
            return redirect()->route('dhcd.events.events.manage')->with('success', trans('dhcd-events::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.events.events.manage')->with('error', trans('dhcd-events::language.messages.error.create'));
        }
    }

    public function create(Request $request)
    { 
        $start_times = session()->get('start_time');
        $end_times = session()->get('end_time');
        $contents = session()->get('content');

        $dataAction = [];
        if ($start_times) {
            foreach ($start_times as $k => $start_time) {

                $dataAction[$k] = [
                    "start_time" => ($start_time) ? $start_time : $start_time,
                    "end_time" => ($end_times[$k]) ? $end_times[$k] : '',
                    "content" => ($contents[$k]) ? $contents[$k] : ''
                ];
            }
        }
        $dataAction = json_encode($dataAction);

        return view('DHCD-EVENTS::modules.events.events.create', compact('dataAction'));
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {

            $event_id = $request->input('id');
            $events = Events::find($event_id);
            if (null != $events) {
                $events->delete($event_id);

                Cache::forget('api_events');

                activity('events')
                    ->performedOn($events)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete events - id: :properties.id, name: ' . $events->name);
                return redirect()->route('dhcd.events.events.manage')->with('success', trans('dhcd-events::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.events.events.manage')->with('error', trans('dhcd-events::language.messages.error.delete'));
            }
        } else {
            return $validator->messages();
        }

    }
    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {

            $event_id = $request->input('event_id');
            $eventDetail = Events::find($event_id);
            $event_detail  = json_decode($eventDetail->event_detail, true);
            $eventDetail->date = date("d/m/Y", strtotime($eventDetail->date));

            $dataAction = [];
            if ($event_detail) {
                foreach ($event_detail as $k => $event) {

                    $dataAction[$k] = [
                        "start_time" => ($event['start_time']) ? $event['start_time'] : '',
                        "end_time" => ($event['end_time']) ? $event['end_time'] : '',
                        "content" => ($event['content']) ? $event['content'] : ''
                    ];
                }
            }
            $dataAction = json_encode($dataAction);

            $data = [
                'event' => $eventDetail,
                'dataAction' => $dataAction
            ];

            return view('DHCD-EVENTS::modules.events.events.edit', $data);
        } else {
            return $validator->messages();
        }

    }
    public function update(EventsRequest $request)
    {
        $event_id = $request->input('event_id');
        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');
        $event_content = $request->input('event_content');
        if(!$start_time){
            return redirect()->route('dhcd.events.events.show',['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.update'));
        }
        else{
            $result = [];
            for ($i = 0; $i < sizeof($start_time); $i++){
                if(!$start_time[$i] || !$end_time[$i] || !$event_content[$i])
                {
                     return redirect()->route('dhcd.events.events.show',['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.update'));
                }
                $result["$i"] = [
                    "start_time" => $start_time[$i],
                    "end_time" => $end_time[$i],
                    "content" => $event_content[$i]
                ];
            }
            $event_detail = json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        $event = Events::find($event_id);
        if (null != $event) {
            $event->name = $request->input('name');
            $event->date = date("Y-m-d", strtotime(str_replace('/', '-', $request->input('date'))));
            $event->content = $request->input('content');
            $event->event_detail = $event_detail;
            if ($event->save()) {

                Cache::forget('api_events');

                activity('events')
                    ->performedOn($event)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update events - event_id: :properties.event_id, name: :properties.name');
                return redirect()->route('dhcd.events.events.manage')->with('success', trans('dhcd-events::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.events.events.show', ['event_id' => $request->input('event_id')])->with('error', trans('dhcd-events::language.messages.error.update'));
            }
        } else {
            return redirect()->route('dhcd.events.events.show', ['event_id' => $request->input('event_id')])->with('error', trans('dhcd-events::language.messages.error.update'));
        }

    }
    public function getModalDelete(Request $request)
    {
        $model = 'events';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.events.events.delete', ['id' => $request->input('event_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->events->findAll())
        ->editColumn('date',function($events){
            $date = $events->date;
           return date("d-m-Y", strtotime($date));})
        ->editColumn('event_detail',function($events){
            $event_detail='<a href=' . route('dhcd.events.events.detail', ['type' => 'event_id', 'event_id' => $events->event_id]) . ' data-toggle="modal" data-target="#event_detail"><button class="btn btn-primary">Chi Tiết
            </button></a>';
            return $event_detail;})
        ->editColumn('status', function ($events) { 
            if($events->status===1){
                return '<lable>Đã Công Khai</label>';
            } else
            {
                return '<lable>Chưa Công Khai</label>';}
            })
            ->addColumn('actions', function ($events) {
                $actions = '';
                if($this->user->canAccess('dhcd.events.events.log')){
                    $actions .='<a href=' . route('dhcd.events.events.log', ['type' => 'event_id', 'event_id' => $events->event_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log events"></i></a>';
                }
                if($this->user->canAccess('dhcd.events.events.show')){
                    $actions .='<a href=' . route('dhcd.events.events.show', ['event_id' => $events->event_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update events"></i></a>';
                }      
                if($this->user->canAccess('dhcd.events.events.confirm-delete')){
                    $actions .='<a href=' . route('dhcd.events.events.confirm-delete', ['event_id' => $events->event_id]). ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete events"></i></a>';
                }       
                return $actions;               
            })
            ->rawColumns(['status','actions','date','event_detail','current_time'])
            ->make();
    }

    public function log(Request $request)
    {
        $model = 'events';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'event_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('event_id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ], $this->messages);

        if (!$validator->fails()) {
            $event_id = $request->input('event_id');
            $events=Events::find($event_id);
            $event_detail  = json_decode($events->event_detail);
            return view('DHCD-EVENTS::modules.events.events.modal_event', compact('event_detail'));
        } else {
            return $validator->messages();
        }
    }
  
}


