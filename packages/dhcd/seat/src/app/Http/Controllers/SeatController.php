<?php

namespace Dhcd\Seat\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Seat\App\Repositories\SeatRepository;
use Dhcd\Seat\App\Http\Requests\SeatRequest;
use Dhcd\Seat\App\Models\Seat;
use Dhcd\Sessionseat\App\Models\Sessionseat;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Cache;

class SeatController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct(SeatRepository $seatRepository)
    {
        parent::__construct();
        $this->seat = $seatRepository;
    }

    public function add(SeatRequest $request)
    {
        $staffname = $request->input('staffname');
        $staffpos = $request->input('staffpos');
        $phone = $request->input('phone');
        if(empty($staffname)) {
            return redirect()->route('dhcd.seat.create')->with('error', trans('dhcd-seat::language.messages.missstaff'));
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($staffname); $i++){
                if(!$staffname[$i])
                {
                    return redirect()->route('dhcd.seat.create')
                        ->with('staffname', $staffname)
                        ->with('staffpos', $staffpos)
                        ->with('phone', $phone)
                        ->with('error', trans('dhcd-seat::language.messages.missstaff'));
                }
                $result[$i] = [
                    "staffname" => $staffname[$i],
                    "staffpos" => $staffpos[$i],
                    "phone" => $phone[$i]
                ];
            }
            $staff = json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        $seat = new Seat($request->all());
        $seat->seat_staff= $staff;
        $seat->save();

        if ($seat->seat_id) {

            Cache::forget('seat_' . $request->input('doan_id') . '_' . $request->input('sessionseat_id'));

            activity('seat')
                ->performedOn($seat)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Seat - name: :properties.name, seat_id: ' . $seat->seat_id);
            return redirect()->route('dhcd.seat.manage')->with('success', trans('dhcd-seat::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.seat.manage')->with('error', trans('dhcd-seat::language.messages.error.create'));
        }
    }

    public function create()
    {
        $url = 'http://dhcd.vnedutech.vn/admin/api/member/group-list';
        $doan = json_decode(file_get_contents($url),true);
        $sessionseat = Sessionseat::all();
        return view('DHCD-SEAT::modules.seat.create', compact('doan', 'sessionseat'));
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seat_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $seat_id = $request->input('seat_id');
            $seat = Seat::find($seat_id);
            if (null != $seat) {
                $seat->delete($seat_id);

                Cache::forget('seat_' . $seat->doan_id . '_' . $seat->sessionseat_id);

                activity('seat')
                    ->performedOn($seat)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete seat - id: :properties.id, name: ' . $seat->seat_id);
                return redirect()->route('dhcd.seat.manage')->with('success', trans('dhcd-seat::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.seat.manage')->with('error', trans('dhcd-seat::language.messages.error.delete'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function manage()
    {
        return view('DHCD-SEAT::modules.seat.manage');
    }

    public function show(SeatRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'seat_id' => 'required|numeric',
        ], $this->messages);

        if (!$validator->fails()) {
            $seat_id = $request->input('seat_id');
            $seat = Seat::find($seat_id);

            if(null != $seat){
                $seat_staff = json_decode($seat->seat_staff, true);
                $dataAction = [];
                if ($seat_staff) {
                    foreach ($seat_staff as $k => $staff) {
                        $dataAction[$k] = [
                            "staffname" => ($staff['staffname']) ? $staff['staffname'] : '',
                            "staffpos" => ($staff['staffpos']) ? $staff['staffpos'] : '',
                            "phone" => ($staff['phone']) ? $staff['phone'] : ''
                        ];
                    }
                }

                $doan_id = $seat->doan_id;
                $url = 'http://dhcd.vnedutech.vn/admin/api/member/group-list';
                $group = json_decode(file_get_contents($url),true);
                $doan='';
                foreach ($group as $val){
                    if($val['group_id']===$doan_id){
                        $doan = $val['name'];
                    }
                }

                $sessionseat_id = $seat->sessionseat_id;
                $x = Sessionseat::all();
                $sessionseat_name ='';
                foreach ($x as $val){
                    if($val['sessionseat_id']===$sessionseat_id){
                        $sessionseat_name = $val['sessionseat_name'];
                    }
                }

                $data = [
                    'sessionseat'=>$x,
                    'sessionseat_name'=>$sessionseat_name,
                    'doan' => $doan,
                    'staff' => $seat,
                    'dataAction' => $dataAction
                ];
                return view('DHCD-SEAT::modules.seat.edit', $data);
            }
        } else {
            return $validator->messages();
        }
    }

    public function update(Request $request)
    {
            $seat_id = $request->input('seat_id');
            $staffname = $request->input('staffname');
            $staffpos = $request->input('staffpos');
            $phone = $request->input('phone');
            if(!$staffname){
                return redirect()->route('dhcd.seat.show',['seat_id' => $seat_id])->with('error', trans('dhcd-seat::language.messages.error.update'));
            } else {
                $result = [];
                for ($i = 0; $i < sizeof($staffname); $i++){
                    if(!$staffname[$i])
                    {
                        return redirect()->route('dhcd.seat.show',['seat_id' => $seat_id])->with('error', trans('dhcd-seat::language.messages.error.update'));
                    }
                    $result["$i"] = [
                        "staffname" => $staffname[$i],
                        "staffpos" => $staffpos[$i],
                        "phone" => $phone[$i]
                    ];
                }
                $staff = json_encode($result,JSON_UNESCAPED_UNICODE);
            }

            $seat = Seat::find($seat_id);
            if (null != $seat) {
                $seat->sessionseat_id = $request->input('sessionseat_id');
                $seat->seat = $request->input('seat');
                $seat->note = $request->input('note');
                $seat->seat_staff = $staff;

                if ($seat->save()) {

                    Cache::forget('seat_' . $seat->doan_id . '_' . $seat->sessionseat_id);

                    activity('seat')
                        ->performedOn($seat)
                        ->withProperties($request->all())
                        ->log('User: :causer.email - Update events - seat_id: :properties.seat_id, name: :properties.name');
                    return redirect()->route('dhcd.seat.manage')->with('success', trans('dhcd-seat::language.messages.success.update'));
                } else {
                    return redirect()->route('dhcd.seat.show', ['seat_id' => $request->input('seat_id')])->with('error', trans('dhcd-seat::language.messages.error.update'));
                }
            } else {
                return redirect()->route('dhcd.seat.show', ['seat_id' => $request->input('seat_id')])->with('error', trans('dhcd-seat::language.messages.error.update'));
            }
    }

    public function getModalDelete(Request $request)
    {
        $model = Seat::find($request->input('seat_id'));
            $validator = Validator::make($request->all(), [
                'seat_id' => 'required|numeric',
            ], $this->messages);
        if(null !=$model){
            $confirm_route = $error = null;

            if (!$validator->fails()) {
                try {
                    $confirm_route = route('dhcd.seat.delete', ['seat_id' => $request->input('seat_id')]);
                    return view('DHCD-SEAT::modules.seat.modal_confirmation', compact('error', 'model', 'confirm_route'));
                } catch (GroupNotFoundException $e) {
                    return view('DHCD-SEAT::modules.seat.modal_confirmation', compact('error', 'model', 'confirm_route'));
                }
                }
            }
         else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'seat';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'seat_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('seat_id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function data()
    {
        $url = 'http://dhcd.vnedutech.vn/admin/api/member/group-list';
        $doan = json_decode(file_get_contents($url),true);

        return Datatables::of($this->seat->findAll())
            ->editColumn('sessionseat_name',function ($seat){
                $sessionseat_id = $seat->sessionseat_id;
                $x = Sessionseat::all();
                $sessionseat_name ='';
                foreach ($x as $val){
                    if($val['sessionseat_id']===$sessionseat_id){
                        $sessionseat_name = $val['sessionseat_name'];
                    }
                }
                return $sessionseat_name;
            })
            ->editColumn('doan_id',function ($seat) use($doan){
                $doan_id = $seat->doan_id;
                $name='';
                foreach ($doan as $val){
                    if($val['group_id']===$doan_id){
                        $name = $val['name'];
                    }
                }
                return $name;
            })
            ->editColumn('seat_staff',function ($seat){
            $result='';
              $seat_staff = json_decode($seat->seat_staff,true);
                  foreach($seat_staff as $key =>$val){
                      $result .= "Nhân Viên Phục Vụ" . ' : ' . $val['staffname'] . '<br>';
                      $result .= "Chức Vụ" . ' : ' . $val['staffpos'] . '<br>';
                      $result .= "Số Điện Thoại". ' : ' . $val['phone'] . '<br>'.'<hr>';
                  }
              return $result;
            })
            ->addColumn('actions', function ($seat) {
                $actions = '';
                if($this->user->canAccess('dhcd.seat.log')){
                    $actions .='<a href=' . route('dhcd.seat.log', ['type' => 'seat_id', 'seat_id' => $seat->seat_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log seat"></i></a>';
                }
                if($this->user->canAccess('dhcd.seat.show')){
                    $actions .='<a href=' . route('dhcd.seat.show', ['seat_id' => $seat->seat_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update seat"></i></a>';
                }
                if($this->user->canAccess('dhcd.seat.confirm-delete')){
                    $actions .='<a href=' . route('dhcd.seat.confirm-delete', ['seat_id' => $seat->seat_id]). ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete seat"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions','seat_staff','doan_id','sessionseat_name'])
            ->make();
    }
}
