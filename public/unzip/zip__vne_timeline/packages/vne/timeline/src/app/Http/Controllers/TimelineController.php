<?php

namespace Vne\Timeline\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Timeline\App\Http\Requests\TimelineRequest;
use Vne\Timeline\App\Repositories\TimelineRepository;
use Vne\Timeline\App\Models\Timeline;
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
        $start_date = explode('/', trim($start));
        $end_date = explode('/', trim($end));
        try {
            $timeline = new Timeline($request->all());
            $timeline->titles = $request->input('titles');
            $timeline->starttime = $start_date[2] . '-' . $start_date[0] . '-' . $start_date[1];
            $timeline->endtime = $end_date[2] . '-' . $end_date[0] . '-' . $end_date[1];
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
        $start_date = $timeline->starttime;
        $end_date = $timeline->endtime;
        $data = [
            'endtime' => date("m/d/Y", strtotime($end_date)),
            'starttime' => date("m/d/Y", strtotime($start_date)),
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
        $start_date = explode('/', trim($start));
        $end_date = explode('/', trim($end));
        $timeline->titles = $request->input('titles');
        $timeline->starttime = $start_date[2] . '-' . $start_date[0] . '-' . $start_date[1];
        $timeline->endtime = $end_date[2] . '-' . $end_date[0] . '-' . $end_date[1];
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
        $data = $this->timeline->findAll()->get();
        return json_encode($data, true);
    }

    public function gettimeline()
    {
        $timeline = Timeline::select('id','titles','starttime','endtime','note')->get()->toArray();
        $titles =['id','titles','starttime','endtime','note'];
        $data = [$titles];
        foreach ($timeline as $key =>$value){
            $x = array_values($value);
            $data[] = $x;
        }
        if ($timeline == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $data], 200);
    }
}
