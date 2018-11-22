<?php

namespace Vne\Timeline\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Timeline\App\Http\Requests\TimelineRequest;
use Vne\Timeline\App\Repositories\TimelineRepository;
use Vne\Timeline\App\Models\Timeline;
use Illuminate\Support\Facades\Cache;
use DateTime;
use Validator;

class TimelineController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(TimelineRepository $timelineRepository)
    {
        parent::__construct();
        $this->timeline = $timelineRepository;
    }

    public function add(TimelineRequest $request)
    {
        $time = $request->input('time');
        list($start, $end) = explode("-", $time);
        $starttime = DateTime::createFromFormat('d/m/Y H:i:s ', $start)->format('Y-m-d H:i:s');
        $endtime = DateTime::createFromFormat(' d/m/Y H:i:s', $end)->format('Y-m-d H:i:s');
        try {
            $timeline = new Timeline($request->all());
            $timeline->titles = $request->input('titles');
            $timeline->starttime = $starttime;
            $timeline->endtime = $endtime;
            $timeline->note = strip_tags($request->input('note'));
            $timeline->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.timeline.create')->with('error', $e->getMessage());
        }
        if ($timeline->id) {
            activity('timeline')
                ->performedOn($timeline)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add TimeLine - name: :properties.name, id: ' . $timeline->id);

            return redirect()->route('vne.timeline.create')->with('success', trans('vne-timeline::language.messages.success.create'));
        } else {
            return redirect()->route('vne.timeline.create')->with('error', trans('vne-timeline::language.messages.error.create'));
        }
    }

    public function create()
    {
        return view('VNE-TIMELINE::modules.timeline.create');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $timeline = $this->timeline->find($id);

        if (null != $timeline) {
            $this->timeline->delete($id);

            activity('timeline')
                ->performedOn($timeline)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete Demo - demo_id: :properties.id, name: ' . $timeline->name);

            return redirect()->route('vne.timeline.create')->with('success', trans('vne-timeline::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.timeline.create')->with('error', trans('vne-timeline::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-TIMELINE::modules.timeline.create');
    }

    public function show(Request $request)
    {
        $id = $request->input('id');
        $timeline = $this->timeline->findOrFail($id);
        $data = [
            'id' => $id,
            'titles' => $timeline->titles,
            'starttime' => date('d/m/Y H:i:s ', strtotime($timeline->starttime)),
            'endtime' => date('d/m/Y H:i:s ', strtotime($timeline->endtime)),
            'note' => $timeline->note,
        ];
        return view('VNE-TIMELINE::modules.timeline.edit', $data);
    }

    public function update(TimelineRequest $request)
    {
        $res = [
            'status' => false,
            'data' => null,
            'messages' => ''
        ];
        $id = (int)$request->input('id');
        $timeline = $this->timeline->findOrFail($id);
        $time = $request->input('time');
        list($start, $end) = explode("-", trim($time));
        $starttime = DateTime::createFromFormat('d/m/Y H:i:s ', $start)->format('Y-m-d H:i:s');
        $endtime = DateTime::createFromFormat(' d/m/Y H:i:s', $end)->format('Y-m-d H:i:s');
        $timeline->titles = $request->input('titles');
        $timeline->starttime = $starttime;
        $timeline->endtime = $endtime;
        $timeline->note = strip_tags($request->input('note'));
        try {
            $timeline->update();
            activity('timeline')
                ->performedOn($timeline)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add TimeLine - name: :properties.name, id: ' . $timeline->id);
            $res['status'] = true;
            return response()->json($res);
        } catch (\Exception $e) {
            $res['messages'] = $e->getMessage();
            return response()->json($res);
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'timeline';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.timeline.delete', ['id' => $request->input('id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

//    public function log(Request $request)
//    {
//        $model = 'demo';
//        $confirm_route = $error = null;
//        $validator = Validator::make($request->all(), [
//            'type' => 'required',
//            'id' => 'required|numeric',
//        ], $this->messages);
//        if (!$validator->fails()) {
//            try {
//                $logs = Activity::where([
//                    ['log_name', $model],
//                    ['subject_id', $request->input('id')]
//                ])->get();
//                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
//            } catch (GroupNotFoundException $e) {
//                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
//            }
//        } else {
//            return $validator->messages();
//        }
//    }

    //Table Data to index page
    public function data()
    {
        $timeline = $this->timeline->findAll()->get();
        $data = [];
        foreach ($timeline as $key => $value) {
            $obj = ['id' => $value->id,
                'titles' => $value->titles,
                'starttime' => date('d-m-Y H:i:s ', strtotime($value->starttime)),
                'endtime' => date('d-m-Y H:i:s ', strtotime($value->endtime)),
                'note' => $value->note,
            ];
            $data[] = $obj;
        }
        return json_encode($data, true);
    }

//    public function gettimeline()
//    {
//        $timeline = Timeline::select('id','titles','starttime','endtime','note')->get()->toArray();
//        $titles =['STT','Tiêu Đề','Thời Gian Bắt Đầu','Thời Gian Kết Thúc','Nội Dung'];
//        $data = [$titles];
//        foreach ($timeline as $key =>$value){
//            $x = array_values($value);
//            $data[] = $x;
//        }
//        if ($timeline == null) {
//            return response()->json(['data' => null], 500);
//        }
//        return response()->json(['data' => $data], 200);
//    }
    public function gettimeline()
    {
        $timeline = Cache::remember('timeline', 30 * 60, function () {
            $timeline = Timeline::select('id', 'titles', 'starttime', 'endtime', 'note')->get()->toArray();
            $data = [];
            foreach ($timeline as $key => $value) {
                $x = array_values($value);
                $data[] = $x;
            }
            return $data;
        });
        $header = ['STT', 'Tiêu Đề', 'Thời Gian Bắt Đầu', 'Thời Gian Kết Thúc', 'Nội Dung'];
        if ($timeline == null) {
            return response()->json(['data' => ['table_header' => $header, 'data_table' => null]], 500)->header('Content-Type', 'application/json')->header('Accept', 'application/json; charset=utf-8');
        }
        return response()->json(['data' => ['table_header' => $header, 'data_table' => $timeline]], 200)->header('Content-Type', 'application/json')->header('Accept', 'application/json; charset=utf-8');
    }
}
