<?php

namespace Vne\Schools\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Schools\App\Http\Requests\UnitRequest;
use Vne\Schools\App\Repositories\UnitRepository;
use Vne\Schools\App\Models\Unit;
use Vne\Schools\App\Models\CatUnit;
use Vne\Schools\App\Models\Province;
use Vne\Schools\App\Models\District;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Validator;

class UnitController extends Controller
{
    protected $_listItem;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(UnitRepository $unitRepository)
    {
        parent::__construct();
        $this->unit = $unitRepository;
    }

    public function add(UnitRequest $request)
    {
        $memname = $request->input('memname');
        $memphone = $request->input('memphone');
        $mememail = $request->input('mememail');
        $mempos = $request->input('mempos');
        if (empty($memname)) {
            $unitmem = null;
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($memname); $i++) {
                if (!$memname[$i]) {
                    return redirect()->route('vne.unit.create')
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
            $unitmem = json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        try {
            $unit = new Unit($request->all());
            $unit->nextid();
            $unit->unitname = $request->input('unitname');
            $unit->parent = (int)$request->input('parent');
            $unit->type = (int)$request->input('type');
            $unit->unitaddress = strip_tags($request->input('unitaddress'));
            $unit->unitprovince = (int)$request->input('province_id');
            $unit->unitdistrict = (int)$request->input('district_id');
            $unit->unitphone = $request->input('unitphone');
            $unit->unitmem = $unitmem;
            $unit->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.unit.create')->with('error', $e->getMessage());
        }
        if ($unit->_id) {
            activity('unit')
                ->performedOn($unit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add unit - unit: :properties.unit, _id' . $unit->_id);
            return redirect()->route('vne.unit.manage')->with('success', trans('vne-schools::language.messages.success.addsuccess'));
        } else {
            return redirect()->route('vne.unit.create')->with('error', trans('vne-schools::language.messages'));
        }
    }

    public function create()
    { $units = Unit::select('*')->orderBy('parent')->get();
        self::getlevel($units);
        $units = $this->_listItem;
        $catunit = CatUnit::all();
        $provinces = Province::all();
        $data = [
            'units' => $units,
            'catunit' => $catunit,
            'provinces' => $provinces,
        ];
        return view('VNE-SCHOOLS::modules.unit.create', $data);
    }

    function getlevel($units)
    {
        $this->_listItem = new Collection();
        if (count($units)>0){
            foreach ($units as $unit) {
                $parent_id = $unit->parent;
                $_id = $unit->_id;

                $unitData['items'][$_id] = $unit;
                $unitData['parents'][$parent_id][] = $_id;
            }
        self::buildLevel(0, $unitData);
        }
    }

    function buildLevel($parentId, $unitData)
    {
      if(isset($unitData['parents'][$parentId]))
      {
          foreach($unitData['parents'][$parentId] as $itemId)
          {
              $item = $unitData['items'][$itemId];
              $item->level = 1;
              if($parentId == 0)
                  $item->level = 0;
              else
                  $item->level = $unitData['items'][$parentId]->level +1;
              $this->_listItem->push($item);
              
              $more = self::buildLevel($itemId, $unitData);
              if(!empty($more))
                  $this->_listItem->push($more);
          }
      }
    }

    public function getdistrict(Request $request)
    {
        return json_encode(District::where('province_id', (int)$request->province_id)->get());
    }

    public function delete(Request $request)
    {
        $_id = (int)$request->input('_id');
        $unit = $this->unit->find($_id);
        if (null != $unit) {
            $this->unit->delete($_id);
            activity('unit')
                ->performedOn($unit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete unit - _id: :properties._id, name: ' . $unit->unitname);

            return redirect()->route('vne.unit.manage')->with('success', trans('vne-schools::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.unit.manage')->with('error', trans('vne-schools::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $count = Unit::all();
        return view('VNE-SCHOOLS::modules.unit.manage', compact('count', $count));
    }

    public function show(UnitRequest $request)
    {
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $_id = (int)$request->input('_id');
            $unit = Unit::findOrFail($_id);
            $unitmem = json_decode($unit->unitmem, true);
            if (isset($unitmem)) {
                $dataAction = [];
                foreach ($unitmem as $k => $mem) {
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
//            $units = Unit::select('*')->orderBy('parent')->get();
            $units = Unit::select('*')->where('unitname','like','đơn vị')->orderBy('parent')->get();
//            dd($units);
            self::getlevel($units);
            $units = $this->_listItem;
            foreach ($units as $key=>$value){
               if($value->_id == $unit->id){
                   $units->forget($key);
               }
            }
//          dd($units);
//            $item = json_encode($item,true);
//            $units->push($item);
            $parent = Unit::select('_id', 'unitname')->where('_id', $unit->parent)->first();
            if(isset($parent)){
                $parent_id = $parent->_id;
            }else{
                $parent_id = 0;
            }
            $type = CatUnit::findOrFail($unit->type);
            $types = CatUnit::all();
            $province = Province::find($unit->unitprovince);
            $provinces = Province::all();
            $district = District::find($unit->unitdistrict);
            $districts = District::all();
            $districtof = District::where('province_id', $unit->unitprovince)->get();

            $data = [
                'unit' => $unit,
                'units' => $units,
                'parent_id' => $parent_id,
                'type' => $type,
                'types' => $types,
                'mem' => $dataAction,
                'province' => $province,
                'provinces' => $provinces,
                'district' => $district,
                'districts' => $districts,
                'districtof' => $districtof,
            ];
            return view('VNE-SCHOOLS::modules.unit.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(UnitRequest $request)
    {
        $memname = $request->input('memname');
        $memphone = $request->input('memphone');
        $mememail = $request->input('mememail');
        $mempos = $request->input('mempos');
        if (empty($memname)) {
            $unitmem = null;
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
            $unitmem = json_encode($result, JSON_UNESCAPED_UNICODE);
        }
        $_id = $request->input('_id');
        $unit = Unit::findOrFail((int)$_id);
        $unit->unitname = $request->input('unitname');
        $unit->unitaddress = strip_tags($request->input('unitaddress'));
        $unit->parent = (int)$request->input('parent');
        $unit->type = (int)$request->input('type');
        $unit->unitprovince = (int)$request->input('province_id');
        $unit->unitdistrict = (int)$request->input('district_id');
        $unit->unitphone = $request->input('unitphone');
        $unit->unitmem = $unitmem;
        if ($unit->update()) {

            activity('unit')
                ->performedOn($unit)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update unit - _id: :properties._id, name: :properties.name');

            return redirect()->route('vne.unit.manage')->with('success', trans('vne-schools::language.messages.success.update'));
        } else {
            return redirect()->route('vne.unit.show', ['_id' => $request->input('_id')])->with('error', trans('vne-schools::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'unit';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.unit.delete', ['_id' => (int)$request->input('_id')]);
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
        $model = 'unit';
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
        $total = Unit::count();
        $units = $this->unit->findAll((int)$start, (int)$length);
        $unitData = array(
            'items' => array(),
            'parents' => array()
        );
        self::getlevel($units);
        $units = Collection::make($this->_listItem);
        $request->merge(['start' => 0]);
        return Datatables::of($units)
            ->addColumn('actions', function ($unit) {
                $actions = '<a href=' . route('vne.unit.log', ['type' => 'unit', '_id' => $unit->_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log unit"></i></a>
                        <a href=' . route('vne.unit.show', ['_id' => $unit->_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update unit"></i></a>
                        <a href=' . route('vne.unit.confirm-delete', ['_id' => $unit->_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete unit"></i></a>';
                return $actions;
            })
            ->editColumn('unitname', function ($unit) {
                $unitname = str_repeat('--', $unit->level) . $unit->unitname;
                return $unitname;
            })
            ->editColumn('type', function ($unit) {
                $type_id = $unit->type;
                $typeitem = CatUnit::findOrFail($type_id);
                $type = $typeitem->catunit;
                return $type;
            })
            ->editColumn('unitprovince', function ($unit) {
                $province = Province::find((int)$unit['unitprovince']);
                $unitprovince = $province['province'];
                return $unitprovince;
            })
            ->editColumn('unitdistrict', function ($unit) {
                $province = District::find((int)$unit['unitdistrict']);
                $unitdistrict = $province['district'];
                return $unitdistrict;
            })
            ->editColumn('unitaddress', function ($unit) {
                $unitaddress = $unit->unitaddress;
                if ($unitaddress == null or $unitaddress == '') {
                    $unitaddress = "Chưa có địa chỉ";
                } else {
                    $unitaddress = strip_tags($unit->unitaddress);
                }
                return $unitaddress;
            })
            ->editColumn('unitphone', function ($unit) {
                $unitphone = $unit['unitphone'];
                if ($unitphone == null or $unitphone == '') {
                    $unitphone = "Chưa có số điện thoại";
                }
                return $unitphone;
            })
            ->editColumn('unitmem', function ($unit) {
                $unitmemdetail = '';
                $unitmem = json_decode($unit['unitmem'], true);
                if (isset($unitmem)) {
                    $unitmemdetail = '<a href=' . route('vne.unit.memdetail', ['type' => '_id', '_id' => $unit->_id]) . ' data-toggle="modal" data-target="#memdetail"><button class="btn btn-primary">Chi Tiết
                    </button></a>';
                }
                return $unitmemdetail;
            })
            ->addIndexColumn()
            ->setTotalRecords($total)
            ->rawColumns(['actions', 'unitmem', 'unitphone', 'unitprovince', 'unitdistrict', 'unitaddress'])
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
            $unit = Unit::findOrFail((int)$_id);
            $memdetail = json_decode($unit->unitmem, true);
            return view('VNE-SCHOOLS::modules.unit.memdetail', compact('memdetail'));
        } else {
            return $validator->messages();
        }
    }

// api trả về thông tin đơn vị lấy theo đơn vị cha
    public function getunitof(Request $request)
    {
        $parent_id = (int)$request->parent_id;
        $unit = Unit::where('parent', $parent_id)->get();
        if ($unit == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $unit], 200);
    }

    //api trả về thông tin đơn vị lấy theo quận huyện
    public function getunits(Request $request)
    {
        $district_id = (int)$request->district_id;
        $unit = Unit::where('unitdistrict', $district_id)->get();
        if ($unit == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $unit], 200);
    }
    //api trả về thông tin đơn vị láy theo id
    public function getunit(Request $request)
    {
        $_id = (int)$request->_id;
        $unit = Unit::find($_id);
        if ($unit == null) {
            return response()->json(['data' => null], 500);
        }
        return response()->json(['data' => $unit], 200);
    }
}
