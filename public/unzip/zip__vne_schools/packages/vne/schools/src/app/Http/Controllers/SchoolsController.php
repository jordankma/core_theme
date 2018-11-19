<?php

namespace Vne\Schools\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Schools\App\Http\Requests\SchoolsRequest;
use Vne\Schools\App\Repositories\SchoolsRepository;
use Vne\Schools\App\Models\Schools;
use Vne\Schools\App\Models\Province;
use Vne\Schools\App\Models\District;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class SchoolsController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(SchoolsRepository $schoolsRepository)
    {
        parent::__construct();
        $this->schools = $schoolsRepository;
    }

    public function add(SchoolsRequest $request)
    {
        $memname = $request->input('memname');
        $memphone = $request->input('memphone');
        $mememail = $request->input('mememail');
        $mempos = $request->input('mempos');
        if (empty($memname)) {
            $schoolmem = null;
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($memname); $i++) {
                if (!$memname[$i]) {
                    return redirect()->route('vne.schools.create')
                        ->with('memname', $memname)
                        ->with('memphone', $memphone)
                        ->with('mempos', $mempos)
                        ->with('mememail', $mememail)
                        ->with('error', trans('vne-schools::language.messages.missmem'));
                }
                $result[$i] = [
                    "memname" => $memname[$i],
                    "memphone" => $memphone[$i],
                    "mempos" => $mempos[$i],
                    "mememail" => $mememail[$i]
                ];
            }
            $schoolmem = json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        if (empty($request->pclass)) {
            $level_id = (int)$request->level_id;
            $schoolunit = $this->equalunit($level_id);
        } else {
            $level_id = (int)$request->level_id;
            $arr = $this->equalunit($level_id);
            $arr1 = $request->pclass;
            $arr2 = array_diff_key($arr, $arr1);
            $schoolunit = $arr1 + $arr2;
        }
        try {
            $schools = new Schools($request->all());
            $schools->nextid();
            $schools->schoolname = $request->input('schoolname');
            $schools->schoollevel = (int)$request->input('level_id');
            $schools->schooladdress = strip_tags($request->input('schooladdress'));
            $schools->schoolprovince = (int)$request->input('province_id');
            $schools->schooldistrict = (int)$request->input('district_id');
            $schools->schoolphone = $request->input('schoolphone');
            $schools->pclass = ($schoolunit);
            $schools->schoolmem = $schoolmem;
            $schools->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.schools.create')->with('error', $e->getMessage());
        }
        if ($schools->_id) {
            activity('schools')
                ->performedOn($schools)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add schools - schools: :properties.schools, _id' . $schools->_id);
            return redirect()->route('vne.schools.manage')->with('success', trans('vne-schools::language.messages.success.addsuccess'));
        } else {
            return redirect()->route('vne.schools.create')->with('error', trans('vne-schools::language.messages'));
        }
    }

    public function create()
    {
        $provinces = Province::all();
        return view('VNE-SCHOOLS::modules.schools.create', compact('provinces', $provinces));
    }

    public function unitcreate()
    {
        $provinces = Province::all();
        return view('VNE-SCHOOLS::modules.unit.create', compact('provinces', $provinces));
    }

    public function getdistrict(Request $request)
    {
        return json_encode(District::where('province_id', (int)$request->province_id)->get());
    }

// hàm trả về khối lớp theo loại trường
    public function getpunit(Request $request)
    {
        $level_id = $request->level_id;
        switch ($level_id) {
            case 1:
                $result = "[{\"id\":1,\"punit\": 1},{\"id\":2,\"punit\": 2},{\"id\":3,\"punit\": 3},{\"id\":4,\"punit\": 4},{\"id\":5,\"punit\": 5}]";
                return $result;
                break;
            case 2:
                $result = "[{\"id\":6,\"punit\": 6},{\"id\":7,\"punit\": 7},{\"id\":8,\"punit\": 8},{\"id\":9,\"punit\": 9}]";
                return $result;
                break;
            case 3:
                $result = "[{\"id\":10,\"punit\": 10},{\"id\":11,\"punit\": 11},{\"id\":12,\"punit\": 12}]";
                return $result;
                break;
            case 4:
                $result = "[{\"id\":13,\"punit\": \"Đại Học\"},{\"id\":14,\"punit\": \"Cao Đẳng\"}]";
                return $result;
                break;
            default:
                $result = "[{\"id\":0,\"punit\": \"Bạn chưa chọn khối\"},]";
                return $result;
        }
    }

    // hàm trả về mảng lớp theo kiểu trường(lelvel) là dữ liệu mẫu trả về để so sánh với input nhập vào
    public function equalunit($level_id)
    {
        switch ($level_id) {
            case 1:
                $result = array("1" => null, "2" => null, "3" => null, "4" => null, "5" => null);
                return $result;
                break;
            case 2:
                $result = array("6" => null, "7" => null, "8" => null, "9" => null);
                return $result;
                break;
            case 3:
                $result = array("10" => null, "11" => null, "12" => null);
                return $result;
                break;
            case 4:
                $result = array("13" => null, "14" => null);
                return $result;
                break;
            default:
                $result = array("1" => null, "2" => null, "3" => null, "4" => null, "5" => null);
                return $result;
        }
    }

    public function delete(Request $request)
    {
        $_id = (int)$request->input('_id');
        $schools = $this->schools->find($_id);
        if (null != $schools) {
            $this->schools->delete($_id);
            activity('schools')
                ->performedOn($schools)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete schools - _id: :properties._id, name: ' . $schools->schoolname);

            return redirect()->route('vne.schools.manage')->with('success', trans('vne-schools::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.schools.manage')->with('error', trans('vne-schools::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $count = Schools::all();
        return view('VNE-SCHOOLS::modules.schools.manage', compact('count', $count));
    }

    public function show(SchoolsRequest $request)
    {
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $_id = (int)$request->input('_id');
            $schools = Schools::findOrFail($_id);
            $schoolmem = json_decode($schools->schoolmem, true);
            if (isset($schoolmem)) {
                $dataAction = [];
                foreach ($schoolmem as $k => $mem) {
                    $dataAction[$k] = [
                        "memname" => ($mem['memname']) ? $mem['memname'] : '',
                        "memphone" => ($mem['memphone']) ? $mem['memphone'] : '',
                        "mememail" => ($mem['mememail']) ? $mem['mememail'] : '',
                        "mempos" => ($mem['mempos']) ? $mem['mempos'] : ''
                    ];
                }
            } else {
                $dataAction = null;
            }
            $province = Province::find($schools->schoolprovince);
            $provinces = Province::all();
            $district = District::find($schools->schooldistrict);
            $districts = District::all();
            $districtof = District::where('province_id', $schools->schoolprovince)->get();
            $punits = $schools->pclass;
            $data = [
                'schools' => $schools,
                'mem' => $dataAction,
                'province' => $province,
                'provinces' => $provinces,
                'district' => $district,
                'districts' => $districts,
                'districtof' => $districtof,
                'punits' => $punits
            ];
            return view('VNE-SCHOOLS::modules.schools.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(Request $request)
    {
        $memname = $request->input('memname');
        $memphone = $request->input('memphone');
        $mememail = $request->input('mememail');
        $mempos = $request->input('mempos');
        if (empty($memname)) {
            $schoolmem = null;
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($memname); $i++) {
                if (!$memname[$i]) {
                    return redirect()->route('vne.schools.create')
                        ->with('memname', $memname)
                        ->with('memphone', $memphone)
                        ->with('mempos', $mempos)
                        ->with('mememail', $mememail)
                        ->with('error', trans('vne-schools::language.messages.missmem'));
                }
                $result[$i] = [
                    "memname" => $memname[$i],
                    "memphone" => $memphone[$i],
                    "mempos" => $mempos[$i],
                    "mememail" => $mememail[$i]
                ];
            }
            $schoolmem = json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        if (empty($request->pclass)) {
            $level_id = (int)$request->level_id;
            $schoolunit = $this->equalunit($level_id);
        } else {
            $level_id = (int)$request->level_id;
            $arr = $this->equalunit($level_id);
            $arr1 = $request->pclass;
            $arr2 = array_diff_key($arr, $arr1);
            $schoolunit = $arr1 + $arr2;
        }
        $_id = $request->input('_id');
        $schools = Schools::findOrFail((int)$_id);
        $schools->schoolname = $request->input('schoolname');
        $schools->schoollevel = (int)$request->input('level_id');
        $schools->schooladdress = strip_tags($request->input('schooladdress'));
        $schools->schoolprovince = (int)$request->input('province_id');
        $schools->schooldistrict = (int)$request->input('district_id');
        $schools->schoolphone = $request->input('schoolphone');
        $schools->pclass = ($schoolunit);
        $schools->schoolmem = $schoolmem;
        $schools->update();
        if ($schools->update()) {

            activity('school')
                ->performedOn($schools)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update school - _id: :properties._id, name: :properties.name');

            return redirect()->route('vne.schools.manage')->with('success', trans('vne-schools::language.messages.success.update'));
        } else {
            return redirect()->route('vne.schools.show', ['_id' => $request->input('_id')])->with('error', trans('vne-schools::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'schools';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.schools.delete', ['_id' => (int)$request->input('_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'schools';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', (int)$request->input('_id')]
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
    public function data(Request $request)
    {
        $start = (int)$request->input('start');
        $length = (int)$request->input('length');
        $total = Schools::count();
        $query = $this->schools->findAll((int)$start, (int)$length);
        $request->merge(['start' => 0]);
        return Datatables::of($query)
            ->addColumn('actions', function ($schools) {
                $actions = '<a href=' . route('vne.schools.log', ['type' => 'schools', '_id' => $schools->_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log schools"></i></a>
                        <a href=' . route('vne.schools.show', ['_id' => $schools->_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update schools"></i></a>
                        <a href=' . route('vne.schools.confirm-delete', ['_id' => $schools->_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete schools"></i></a>';
                return $actions;
            })
            ->editColumn('schoollevel', function ($schools) {
                $level_id = $schools['schoollevel'];
//                switch ($level_id){
//                case $level_id == 1:
//                    $level_id = "Tiểu Học";
//                    return $level_id;
//                break;
//                case $level_id == 2:
//                    $level_id = "Trung Học Cơ Sở";
//                    return $level_id;
//                    break;
//                case $level_id == 3:
//                    $level_id = "Trung Học Phổ Thông";
//                    return $level_id;
//                    break;
//                case $level_id == 4:
//                    $level_id = "Đại Học ,Cao Đẳng";
//                    return $level_id;
//                    break;
//                default:
//                    $level_id = "Tiểu Học";
//                    return $level_id;
//                }

                if ($level_id == 1) {
                    $level_id = "Tiểu Học";
                }
                if ($level_id == 2) {
                    $level_id = "Trung Học Cơ Sở";
                }
                if ($level_id == 3) {
                    $level_id = "Trung Học Phổ Thông";
                }
                if ($level_id == 4) {
                    $level_id = "Đại Học ,Cao Đẳng";
                }
                return $level_id;
            })
            ->editColumn('schoolprovince', function ($schools) {
                $province = Province::find((int)$schools['schoolprovince']);
                $schoolprovince = $province['province'];
                return $schoolprovince;
            })
            ->editColumn('schooldistrict', function ($schools) {
                $province = District::find((int)$schools['schooldistrict']);
                $schooldistrict = $province['district'];
                return $schooldistrict;
            })
            ->editColumn('pclass', function ($schools) {
                $pclass = '';
                $punit = ($schools['pclass']);
                if($punit == null or $punit == ''){
                    $pclass .= 'Chưa có khối, lớp nào';
                }
                else {
                    $pclass = '';
                    foreach ($punit as $key => $value) {
                        if ($key == 13) {
                            $pclass .= "Đại Học :<br>";
                            if ($value == null || $value == '') {
                                $pclass .= "Chưa có lớp nào";
                            } else {
                                foreach ($value as $k => $v) {
                                    $pclass .= "Lớp:" . $v . "<br>";
                                }
                            }
                        } elseif ($key == 14) {
                            $pclass .= "Cao Đẳng :<br>";
                            if ($value == null || $value == '') {
                                $pclass .= "Chưa có lớp nào";
                            } else {
                                foreach ($value as $k => $v) {
                                    $pclass .= "Lớp:" . $v . "<br>";
                                }
                            }
                        } else {
                            $pclass .= "Khối :" . $key . "<br>";
                            if ($value == null || $value == '') {
                                $pclass .= "Chưa có lớp nào";
                            } else {
                                foreach ($value as $k => $v) {
                                    $pclass .= "Lớp:" . $v . "<br>";
                                }
                            }
                        }
                        $pclass = $pclass . "<hr class=hr>";
                    }
                }
                return $pclass;
            })
            ->editColumn('schooladdress', function ($schools){
                $schooladdress = $schools->schooladdress;
                if($schooladdress == null or $schooladdress == ''){
                    $schooladdress = "Chưa có địa chỉ";
                }
                else{
                    $schooladdress = strip_tags($schools->schooladdress);
                }
               return $schooladdress;
            })
            ->editColumn('schoolphone', function ($schools){
                $schoolphone = $schools['schoolphone'];
                if($schoolphone == null or $schoolphone == ''){
                    $schoolphone = "Chưa có số điện thoại";
                }
                return $schoolphone;
            })
            ->editColumn('schoolmem', function ($schools) {
                $schoolmemdetail = '';
                $schoolmem = json_decode($schools['schoolmem'], true);
                if (isset($schoolmem)) {
                    $schoolmemdetail = '<a href=' . route('vne.schools.memdetail', ['type' => '_id', '_id' => $schools->_id]) . ' data-toggle="modal" data-target="#memdetail"><button class="btn btn-primary">Chi Tiết
                    </button></a>';
                }
                return $schoolmemdetail;
            })
            ->addIndexColumn()
            ->setTotalRecords($total)
            ->rawColumns(['actions', 'schoolmem', 'schoollevel', 'schoolprovince', 'schooldistrict', 'pclass','schooladdress'])
            ->make(true);
    }

    //Hàm tra về data người phụ trách
    public function memdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);

        if (!$validator->fails()) {
            $_id = $request->input('_id');
            $schools = Schools::findOrFail((int)$_id);
            $memdetail = json_decode($schools->schoolmem, true);
            return view('VNE-SCHOOLS::modules.schools.memdetail', compact('memdetail'));
        } else {
            return $validator->messages();
        }
    }

// api trả về thông tin trường (lấy theo quận huyên)
    public function getschools(Request $request)
    {
        $_id = (int)$request->_id;
        $schools = Schools::where('schooldistrict', $_id)->get();
        if ($schools == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $schools], 200);
    }

}
