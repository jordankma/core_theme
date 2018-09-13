<?php

namespace Dhcd\Hotel\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Hotel\App\Repositories\HotelRepository;
use Dhcd\Hotel\App\Models\Hotel;
use Dhcd\Hotel\App\Http\Requests\HotelRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Cache;

class HotelController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    public function __construct(HotelRepository $hotelRepository)
    {
        parent::__construct();
        $this->hotel = $hotelRepository;
    }
    public function add(HotelRequest $request)
    {
        $staffname = $request->input('staffname');
        $staffpos = $request->input('staffpos');
        $phone = $request->input('phone');
        $img = $request->input('img');
        if (empty($staffname)) {
            return redirect()->route('dhcd.hotel.create')->with('error', trans('dhcd-hotel::language.messages.missstaff'));
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($staffname); $i++) {
                if (!$staffname[$i]) {
                    return redirect()->route('dhcd.hotel.create')
                        ->with('staffname', $staffname)
                        ->with('staffpos', $staffpos)
                        ->with('phone', $phone)
                        ->with('error', trans('dhcd-hotel::language.messages.missstaff'));
                }
                $result[$i] = [
                    "staffname" => $staffname[$i],
                    "staffpos" => $staffpos[$i],
                    "phone" => $phone[$i]
                ];
            }
            $staff = json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        $hotel = new Hotel($request->all());
        $hotel->doan_id = $request->has('doan_id') ? implode(",",$request->input('doan_id')) : null;
        $hotel->hotel_staff = $staff;
        $hotel->img = $img;
        $hotel->save();

        if ($hotel->hotel_id) {

            Cache::forget('hotels');
            Cache::forget('data_api_hotels');
            $doan_arr = implode(',', $hotel->doan_id);
            if (count($doan_arr) > 0) {
                foreach ($doan_arr as $doan_id) {
                    Cache::forget('hotel_' . $doan_id);
                    Cache::forget('data_api_hotel_' . $doan_id);
                }
            }

            activity('hotel')
                ->performedOn($hotel)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add hotel - hotel: :properties.hotel, hotel_id: ' . $hotel->hotel_id);
            return redirect()->route('dhcd.hotel.manage')->with('success', trans('dhcd-hotel::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.hotel.manage')->with('error', trans('dhcd-hotel::language.messages.error.create'));

        }
    }

    public function create()
    {
        $url = config('app.url') . '/admin/api/member/group-list';
        $doan = json_decode(file_get_contents($url),true);

        return view('DHCD-HOTEL::modules.hotel.create', ['doan'=>$doan]);
    }

    public function delete(HotelRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $hotel_id = $request->input('hotel_id');
            $hotel = Hotel::find($hotel_id);
            if (null != $hotel) {
                $hotel->delete($hotel_id);

                Cache::forget('hotels');
                Cache::forget('data_api_hotels');
                $doan_arr = implode(',', $hotel->doan_id);
                if (count($doan_arr) > 0) {
                    foreach ($doan_arr as $doan_id) {
                        Cache::forget('hotel_' . $doan_id);
                        Cache::forget('data_api_hotel_' . $doan_id);
                    }
                }

                activity('hotel')
                    ->performedOn($hotel)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete hotel - id: :properties.id, name: ' . $hotel->hotel_id);
                return redirect()->route('dhcd.hotel.manage')->with('success', trans('dhcd-hotel::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.hotel.manage')->with('error', trans('dhcd-hotel::language.messages.error.delete'));
            }
        } else {
            return $validator->messages();
        }
    }
    public function manage()
    {
        return view('DHCD-HOTEL::modules.hotel.manage');
    }
    public function show(HotelRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $hotel_id = $request->input('hotel_id');
            $hotel = Hotel::find($hotel_id);
            if (null !=$hotel) {
                $hotel_staff = json_decode($hotel->hotel_staff, true);
                $dataAction = [];
                if ($hotel_staff) {
                    foreach ($hotel_staff as $k => $staff) {
                        $dataAction[$k] = [
                            "staffname" => ($staff['staffname']) ? $staff['staffname'] : '',
                            "staffpos" => ($staff['staffpos']) ? $staff['staffpos'] : '',
                            "phone" => ($staff['phone']) ? $staff['phone'] : ''
                        ];
                    }
                }
                $doan_id = explode("," , $hotel->doan_id);
                $url = config('app.url') . '/admin/api/member/group-list';
                $doan = json_decode(file_get_contents($url),true);

                $data = [
                    'doan_id' => $doan_id,
                    'doan' => $doan,
                    'staff' => $hotel,
                    'dataAction' => $dataAction
                ];
    //            dd($data);
                return view('DHCD-HOTEL::modules.hotel.edit', $data);
            }
            else {
                return $validator->messages();
            }
        } else {
            return $validator->messages();
        }
    }
    public function update(HotelRequest $request)
    {
        $hotel_id = $request->input('hotel_id');
        $staffname = $request->input('staffname');
        $staffpos = $request->input('staffpos');
        $phone = $request->input('phone');
        foreach ($staffname as $val){
            if($val == null or $val == ''){
                return redirect()->route('dhcd.hotel.show',['hotel_id' => $hotel_id])->with('error', trans('dhcd-hotel::language.messages.error.update'));
            }
            else{
                $result = [];
                for ($i = 0; $i < sizeof($staffname); $i++){
                    if(!$staffname[$i])
                    {
                        return redirect()->route('dhcd.hotel.show',['hotel_id' => $hotel_id])->with('error', trans('dhcd-hotel::language.messages.error.update'));
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
        $hotel = Hotel::find($hotel_id);
        if (null != $hotel) {
            $hotel->hotel = $request->input('hotel');
            $hotel->note = $request->input('note');
            $hotel->address = $request->input('address');
            $hotel->img = $request->input('img');
            $hotel->doan_id = $request->has('doan_id') ? implode(",",$request->input('doan_id')) : null;
            $hotel->hotel_staff = $staff;
            if ($hotel->save()) {

                Cache::forget('hotels');
                Cache::forget('data_api_hotels');
                if ($request->has('doan_id')) {
                    foreach ($request->input('doan_id') as $doan_id) {
                        Cache::forget('hotel_' . $doan_id);
                        Cache::forget('data_api_hotel_' . $doan_id);
                    }
                }

                activity('hotel')
                    ->performedOn($hotel)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update hotel - hotel_id: :properties.hotel_id, doan: :properties.doan');
                return redirect()->route('dhcd.hotel.manage')->with('success', trans('dhcd-hotel::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.hotel.show', ['hotel_id' => $request->input('hotel_id')])->with('error', trans('dhcd-hotel::language.messages.error.update'));
            }
        } else {
            return redirect()->route('dhcd.hotel.show', ['hotel_id' => $request->input('hotel_id')])->with('error', trans('dhcd-hotel::language.messages.error.update'));
        }
    }
    public function log(Request $request)
    {
    $model = 'hotel';
    $confirm_route = $error = null;
    $validator = Validator::make($request->all(), [
        'type' => 'required',
        'hotel_id' => 'required|numeric',
    ], $this->messages);
    if (!$validator->fails()) {
        try {
            $logs = Activity::where([
                ['log_name', $model],
                ['subject_id', $request->input('hotel_id')]
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
        $url = config('app.url') . '/admin/api/member/group-list';
        $doan = json_decode(file_get_contents($url),true);
    return Datatables::of($this->hotel->findAll())
        ->editColumn('img',function ($hotel){
           $img = $hotel->img;
           return '<img src=' . config('site.url_storage') .  $img . ' height="auto" width="100%">';
        })
        ->editColumn('doan_id',function ($hotel) use ($doan){
            $doan_id = explode("," , $hotel->doan_id);
            $name='';
            foreach ($doan as $val){
                $name .= (in_array($val['group_id'], $doan_id)) ? $val['name'].' , ' : '';
            }
            return $name;
        })
        ->editColumn('hotel_staff',function ($hotel){
            $result='';
            $hotel_staff = json_decode($hotel->hotel_staff,true);
            foreach($hotel_staff as $key =>$val){
                $result .= "Nhân Viên Phục Vụ" . ' : ' . $val['staffname'] . '<br>';
                $result .= "Chức Vụ" . ' : ' . $val['staffpos'] . '<br>';
                $result .= "Số Điện Thoại". ' : ' . $val['phone'] . '<br>'.'<hr>';
            }
            return $result;
        })
        ->addColumn('actions', function ($hotel) {
            $actions = '';
            if($this->user->canAccess('dhcd.hotel.log')){
                $actions .='<a href=' . route('dhcd.hotel.log', ['type' => 'hotel_id', 'hotel_id' => $hotel->hotel_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log hotel"></i></a>';
            }
            if($this->user->canAccess('dhcd.hotel.show')){
                $actions .='<a href=' . route('dhcd.hotel.show', ['hotel_id' => $hotel->hotel_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update hotel"></i></a>';
            }
            if($this->user->canAccess('dhcd.hotel.confirm-delete')){
                $actions .='<a href=' . route('dhcd.hotel.confirm-delete', ['hotel_id' => $hotel->hotel_id]). ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete hotel"></i></a>';
            }
            return $actions;
        })
        ->rawColumns(['actions','hotel_staff','name','img'])
        ->make();
    }
    public function getModalDelete(Request $request)
    {
        $model = Hotel::find($request->input('hotel_id'));
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'hotel_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.hotel.delete', ['hotel_id' => $request->input('hotel_id')]);
                return view('DHCD-HOTEL::modules.hotel.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-HOTEL::modules.hotel.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
}
