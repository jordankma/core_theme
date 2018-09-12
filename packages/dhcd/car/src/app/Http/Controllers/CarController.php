<?php

namespace Dhcd\Car\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Car\App\Repositories\CarRepository;
use Dhcd\Car\App\Models\Car;
use Dhcd\Car\App\Http\Requests\CarRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Cache;

class CarController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(CarRepository $carRepository)
    {
        parent::__construct();
        $this->car = $carRepository;
    }

    public function add(CarRequest $request)
    {
        $staffname = $request->input('staffname', '');
        $staffpos = $request->input('staffpos', '');
        $phone = $request->input('phone', '');
        $car_bs = $request->input('car_bs', '');
        $img = $request->input('img', '');
        $result = [];
        if(empty($staffname)) {
            $result = [];
            $staff = json_encode($result,JSON_UNESCAPED_UNICODE);
//            return redirect()->route('dhcd.car.create')->with('error', trans('dhcd-car::language.messages.error.missstaff'));
        } else {
            for ($i = 0; $i < sizeof($staffname); $i++){
                if(!$staffname[$i])
                {
                    return redirect()->route('dhcd.car.create')
                        ->with('staffname', $staffname)
                        ->with('staffpos', $staffpos)
                        ->with('phone', $phone)
                        ->with('error', trans('dhcd-car::language.messages.error.create'));
                }
                $result[$i] = [
                    "staffname" => $staffname[$i],
                    "staffpos" => $staffpos[$i],
                    "phone" => $phone[$i]
                ];
            }
            $staff = json_encode($result,JSON_UNESCAPED_UNICODE);
        }
        
        $car = new Car($request->all());
        $car->doan_id = $request->has('doan_id') ? implode(",",$request->input('doan_id')) : null;
        $car->car_staff= $staff;
        $car->car_bs= $car_bs;
        $car->img= $this->toURLFriendly($img);
        $car->save();

        if ($car->car_id) {
            activity('seat')
                ->performedOn($car)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Seat - name: :properties.name, seat_id: ' . $car->car_id);
            return redirect()->route('dhcd.car.manage')->with('success', trans('dhcd-car::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.car.manage')->with('error', trans('dhcd-car::language.messages.error.create'));
        }
    }

    public function create()
    {
        $url = config('app.url') . '/admin/api/member/group-list';
        $doan = json_decode(file_get_contents($url),true);
        return view('DHCD-CAR::modules.car.create',['doan'=>$doan]);
    }

    public function delete(CarRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $car_id = $request->input('car_id');
            $car = Car::find($car_id);
            if (null != $car) {
                $car->delete($car_id);

                $doan_arr = implode(',', $car->doan_id);
                if (count($doan_arr) > 0) {
                    foreach ($doan_arr as $doan_id) {
                        Cache::forget('car_' . $doan_id);
                    }
                }

                activity('car')
                    ->performedOn($car)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete car - id: :properties.id, name: ' . $car->car_id);
                return redirect()->route('dhcd.car.manage')->with('success', trans('dhcd-car::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.car.manage')->with('error', trans('dhcd-car::language.messages.error.delete'));
            }
        } else {
            return $validator->messages();
        }
    }
    public function manage()
    {
        return view('DHCD-CAR::modules.car.manage');
    }
    public function show(CarRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $car_id = $request->input('car_id');
            $car = Car::find($car_id);
            if(null != $car){
                $car_staff = json_decode($car->car_staff, true);
                $dataAction = [];
                if ($car_staff) {
                    foreach ($car_staff as $k => $staff) {

                        $dataAction[$k] = [
                            "staffname" => ($staff['staffname']) ? $staff['staffname'] : '',
                            "staffpos" => ($staff['staffpos']) ? $staff['staffpos'] : '',
                            "phone" => ($staff['phone']) ? $staff['phone'] : ''
                        ];
                    }
                }
                $doan_id = explode("," , $car->doan_id);
                $url = config('app.url') . '/admin/api/member/group-list';
                $doan = json_decode(file_get_contents($url),true);
                    $data = [
                        'doan_id' => $doan_id,
                        'doan' => $doan,
                        'staff' => $car,
                        'dataAction' => $dataAction
                    ];
                    return view('DHCD-CAR::modules.car.edit', $data);
                }
            } else {
            return $validator->messages();
        }
    }

    public function update(CarRequest $request)
    {
        $car_id = $request->input('car_id');
        $staffname = $request->input('staffname');
        $staffpos = $request->input('staffpos');
        $phone = $request->input('phone');
         foreach ($staffname as $val){
             $result = [];
            if($val == null or $val == ''){
                $staff = json_encode($result,JSON_UNESCAPED_UNICODE);
    //            return redirect()->route('dhcd.car.show',['car_id' => $car_id])->with('error', trans('dhcd-car::language.messages.error.update'));
            }
            else{
                for ($i = 0; $i < sizeof($staffname); $i++){
                    if(!$staffname[$i])
                    {
                        return redirect()->route('dhcd.car.show',['car_id' => $car_id])->with('error', trans('dhcd-car::language.messages.error.update'));
                    }
                    $result["$i"] = [
                        "staffname" => $staffname[$i],
                        "staffpos" => $staffpos[$i],
                        "phone" => $phone[$i]
                    ];
                }
                $staff = json_encode($result,JSON_UNESCAPED_UNICODE);
            }
        }
        $car = Car::find($car_id);
        if (null != $car) {
            $car->doan_id = implode("," , $request->input('doan_id'));
            $car->car_num = $request->input('car_num', 0);
            $car->car_bs = $request->input('car_bs', '');
            $car->img = $this->toURLFriendly($request->input('img', ''));
            $car->note = $request->input('note', '');
            $car->car_staff= $staff;
            if ($car->save()) {

                if ($request->has('doan_id')) {
                    foreach ($request->input('doan_id') as $doan_id) {
                        Cache::forget('car_' . $doan_id);
                    }
                }

                activity('car')
                    ->performedOn($car)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update car - car_id: :properties.car_id, name: :properties.name');
                return redirect()->route('dhcd.car.manage')->with('success', trans('dhcd-car::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.car.show', ['car_id' => $request->input('car_id')])->with('error', trans('dhcd-car::language.messages.error.update'));
            }
        } else {
            return redirect()->route('dhcd.car.show', ['car_id' => $request->input('car_id')])->with('error', trans('dhcd-car::language.messages.error.update'));
        }
    }

    public function getModalDelete(CarRequest $request)
    {
        $model = Car::find($request->input('car_id'));
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'car_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.car.delete', ['car_id' => $request->input('car_id')]);
                return view('DHCD-CAR::modules.car.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-CAR::modules.car.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'car';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'car_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('car_id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    { 
        $url = config('app.url') . '/admin/api/member/group-list';
        $doan = json_decode(file_get_contents($url),true);
        return Datatables::of($this->car->findAll())
            ->editColumn('img',function ($car){
                $img = $car->img;
                return '<img src='.config('site.url_storage') . $img.' height="120" width="120">';
            })
            ->editColumn('doan_id', function ($car) use($doan) {
            $doan_id = explode("," , $car->doan_id);
            $name='';
            foreach ($doan as $val){
                $name .= (in_array($val['group_id'], $doan_id)) ? $val['name'].' , ' : '';
            }
            return $name;
            })
            ->editColumn('car_staff', function ($car) {
                $result = '';
                $car_staff = json_decode($car->car_staff, true);
                foreach ($car_staff as $key => $val) {
                    $result .= "Nhân Viên Phục Vụ" . ' : ' . $val['staffname'] . '<br>';
                    $result .= "Chức Vụ" . ' : ' . $val['staffpos'] . '<br>';
                    $result .= "Số Điện Thoại" . ' : ' . $val['phone'] . '<br>' . '<hr>';
                }
                return $result;
            })
            ->addColumn('actions', function ($car) {
                $actions = '';
                if ($this->user->canAccess('dhcd.car.log')) {
                    $actions .= '<a href=' . route('dhcd.car.log', ['type' => 'car_id', 'car_id' => $car->car_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log car"></i></a>';
                }
                if ($this->user->canAccess('dhcd.car.show')) {
                    $actions .= '<a href=' . route('dhcd.car.show', ['car_id' => $car->car_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update car"></i></a>';
                }
                if ($this->user->canAccess('dhcd.car.confirm-delete')) {
                    $actions .= '<a href=' . route('dhcd.car.confirm-delete', ['car_id' => $car->car_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete car"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions', 'car_staff', 'doan_id','img'])
            ->make();
    }
}
