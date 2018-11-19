<?php

namespace Vne\Schools\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Vne\Schools\App\Repositories\ProvinceRepository;
use Vne\Schools\App\Http\Requests\ProvinceRequest;
use Vne\Schools\App\Models\Province;
use Vne\Schools\App\Models\District;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class ProvinceController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );

    public function __construct(ProvinceRepository $provinceRepository)
    {
        parent::__construct();
        $this->province = $provinceRepository;
    }

    public function add(ProvinceRequest $request)
    {
        try {
            $province = new Province($request->all());
            $province->nextid();
            $province->province = strip_tags($request->input('province'));
            $province->region = strip_tags($request->input('region'));
            $province->alias = str_slug($request->input('province'));
            $province->save();
        } catch (\Exception $e) {
            return redirect()->route('vne.schools.province.create')->with('error', $e->getMessage());
        }
        if ($province->_id) {

            activity('province')
                ->performedOn($province)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Province - name::properties.name, _id: ' . $province->_id);

            return redirect()->route('vne.schools.province.manage')->with('success', trans('vne-schools::language.messages.success.create'));
        } else {
            return redirect()->route('vne.schools.province.manage')->with('error', trans('vne-schools::language.messages.error.create'));
        }
    }

    public function create()
    {
        return view('VNE-SCHOOLS::modules.schools.province.create');
    }

    public function delete(ProvinceRequest $request)
    {
        $_id = (int)$request->input('_id');
        $province = Province::findOrFail($_id);
        $district = District::where('province_id',$_id);
        if (null != $province) {
            $province->delete($_id);
            //xóa rằng buộc
            $district->delete($_id);
            activity('province')
                ->performedOn($province)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete Province - _id::properties._id, name: ' . $province->province);

            return redirect()->route('vne.schools.province.manage')->with('success', trans('vne-schools::language.messages.success.delete'));
        } else {
            return redirect()->route('vne.schools.province.manage')->with('error', trans('vne-schools::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        return view('VNE-SCHOOLS::modules.schools.province.manage');
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $_id = (int)$request->input('_id');
            $province = Province::findOrFail($_id);
            $data = [
                'province' => $province
            ];
            return view('VNE-SCHOOLS::modules.schools.province.edit', $data);
        } else {
            return $validator->messages();
        }
    }

    public function update(ProvinceRequest $request)
    {
        $_id = (int)$request->input('_id');
        $province = Province::findOrFail($_id);
        $province->province = strip_tags($request->input('province'));
        $province->alias = str_slug($request->input('province'));
        $province->region = strip_tags($request->input('region'));
        $province->save();
        if ($province->_id) {
            activity('province')
                ->performedOn($province)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update Province - _id::properties._id, name: :properties.name');

            return redirect()->route('vne.schools.province.manage')->with('success', trans('vne-schools::language.messages.success.update'));
        } else {
            return redirect()->route('vne.schools.province.show', ['_id' => $request->input('_id')])->with('error', trans('vne-province::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'province';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('vne.schools.province.delete', ['_id' => $request->input('_id')]);
                return view('VNE-SCHOOLS::modules.schools.province.modal_confirm', compact('success', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return  view('VNE-SCHOOLS::modules.schools.province.modal_confirm', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'province';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            '_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('_id')]
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
        return Datatables::of($this->province->findAll())
            ->addColumn('actions', function ($province) {
                $actions = '<a href=' . route('vne.schools.province.log', ['type' => 'province', '_id' => $province->_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log province"></i></a>
                        <a href=' . route('vne.schools.province.show', ['_id' => $province->_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update province"></i></a>
                        <a href=' . route('vne.schools.province.confirm-delete', ['_id' => $province->_id]) . ' data-toggle="modal" data-target="#modal_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete province"></i></a>';

                return $actions;
            })
            ->addIndexColumn()
            ->rawColumns(['actions'])
            ->make();
    }
    public function getprovince()
    {
        $province = Province::all();
        if($province == null){
            return response()->json(['data'=> null],500);
        }
        return response()->json(['data'=>$province],200);
    }
}
