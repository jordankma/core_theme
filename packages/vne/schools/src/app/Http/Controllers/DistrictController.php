<?php

namespace Vne\Schools\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Schools\App\Repositories\DistrictRepository;
use Vne\Schools\App\Http\Requests\DistrictRequest;
use Vne\Schools\App\Models\District;
use Vne\Schools\App\Models\Province;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class DistrictController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(DistrictRepository $districtRepository)
    {
        parent::__construct();
        $this->district = $districtRepository;
    }

    public function add(DistrictRequest $request)
    {
        $province = Province::findOrFail((int)$request->input('province_id'));
        try {
            $district = new District($request->all());
            $district->nextid();
            $district->province_id = (int)$request->input('province_id');
            $district->province = strip_tags($province->province);
            $district->district = strip_tags($request->input('district'));
            $district->alias = str_slug($request->input('district'));
            $district->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.schools.district.manage')->with('error', $e->getMessage());
        }
        if ((int)$district->_id) {
            activity('district')
                ->performedOn($district)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add District - name::properties.name, _id: ' . (int)$district->_id);

            return redirect()->route('vne.schools.district.manage')->with('success', trans('vne-schools::language.messages.success.create'));
        } else {
            return redirect()->route('vne.schools.district.manage')->with('error', trans('vne-schools::language.messages.error.create'));
        }
    }

    public function create()
    {
        $provinces = Province::all();
        $count = Province::count();
        if ($count == 0) {
            toastr()->warning(trans('vne-schools::language.messages.error.missingprovince'));
            return view('VNE-SCHOOLS::modules.schools.district.create', compact('provinces', $provinces));
        }
        return view('VNE-SCHOOLS::modules.schools.district.create', compact('provinces', $provinces));
    }

    public function delete(Request $request)
    {
        $_id = (int)$request->input('_id');
        $district = $this->district->find($_id);

        if (null != $district) {
            $this->district->delete($_id);

            activity('district')
                ->performedOn($district)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete District - _id: :properties._id, name: ' . $district->district);

            return redirect()->route('vne.schools.district.manage')->with('success', trans('vne-schools::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.schools.district.manage')->with('error', trans('vne-schools::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-SCHOOLS::modules.schools.district.manage');
    }

    public function show(DistrictRequest $request)
    {
        $_id = (int)$request->input('_id');
        $districts = District::findOrFail($_id);
        $provinces = Province::all();
        $data = [
            'districts' => json_decode($districts),
            'provinces' => $provinces
        ];

        return view('VNE-SCHOOLS::modules.schools.district.edit', $data);
    }

    public function update(DistrictRequest $request)
    {
        $province = Province::findOrFail((int)$request->input('province_id'));
        try {
            $_id = (int)$request->input('_id');
            $district = District::findOrFail($_id);
            $district->district = strip_tags($request->input('district'));
            $district->alias = str_slug($request->input('district'));
            $district->province_id = (int)$request->input('province_id');
            $district->province = strip_tags($province->province);
            $district->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.schools.district.show')->with('error', $e->getMessage());
        }
        if ($district->save()) {

            activity('district')
                ->performedOn($district)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update District - _id::properties._id, name::properties.name');

            return redirect()->route('vne.schools.district.manage')->with('success', trans('vne-schools::language.messages.success.update'));
        } else {
            return redirect()->route('vne.schools.district.show', ['_id' => $request->input('_id')])->with('error', trans('vne-schools::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'district';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.schools.district.delete', ['_id' => (int)$request->input('_id')]);
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
        $model = 'district';
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
        return Datatables::of($this->district->findAll())
            ->addColumn('actions', function ($district) {
                $actions = '<a href=' . route('vne.schools.district.log', ['type' => 'district', '_id' => (int)$district->_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log district"></i></a>
                        <a href=' . route('vne.schools.district.show', ['_id' => (int)$district->_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update district"></i></a>
                        <a href=' . route('vne.schools.district.confirm-delete', ['_id' => $district->_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete district"></i></a>';
                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }
    public function getdistrict(Request $request)
    {
        $_id = (int)$request->_id;
        $district = District::find($_id);
        if($district == null){
            return response()->json(['data'=> null],500);
        }
        return response()->json(['data'=>$district],200);
    }
    public function getdistricts(Request $request)
    {
        $_id = (int)$request->_id;
        $district = District::where('province_id',$_id)->get();
        if($district == null){
            return response()->json(['data'=> null],500);
        }
        return response()->json(['data'=>$district],200);
    }
}
