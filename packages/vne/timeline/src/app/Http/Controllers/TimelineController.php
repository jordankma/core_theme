<?php

namespace Vne\Timeline\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use phpDocumentor\Reflection\DocBlock;
use Vne\Timeline\App\Http\Requests\TimelineRequest;
use Vne\Timeline\App\Repositories\TimelineRepository;
use Vne\Timeline\App\Models\Timeline;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
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
        $starttime = explode('/', trim($start));
        $endtime = explode('/', trim($end));
        try {
            $timeline = new Timeline($request->all());
            $timeline->titles = $request->input('titles');
            $timeline->starttime = $starttime[2] . '-' . $starttime[0] . '-' . $starttime[1];
            $timeline->endtime = $endtime[2] . '-' . $endtime[0] . '-' . $endtime[1];
            $timeline->note = $request->input('note');
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
        $starttime = $timeline->starttime;
        $endtime = $timeline->endtime;
        $data = [
            'endtime' => date("m/d/Y", strtotime($endtime)),
            'starttime' => date("m/d/Y", strtotime($starttime)),
            'timeline' => $timeline
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
        $starttime = explode('/', trim($start));
        $endtime = explode('/', trim($end));
        $timeline->titles = $request->input('titles');
        $timeline->starttime = $starttime[2] . '-' . $starttime[0] . '-' . $starttime[1];
        $timeline->endtime = $endtime[2] . '-' . $endtime[0] . '-' . $endtime[1];
        $timeline->note = $request->input('note');
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
        $data = $this->timeline->findAll()->get();
        return json_encode($data, true);
    }

    public function gettimeline()
    {
        $timeline = Timeline::all();
        if ($timeline == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $timeline], 200);
    }
}
