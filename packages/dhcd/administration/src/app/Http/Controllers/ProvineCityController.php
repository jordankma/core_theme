<?php

namespace Dhcd\Administration\App\Http\Controllers;

use Illuminate\Http\Request;
use Dhcd\Administration\App\Http\Requests\ProvineCityRequest;
use Adtech\Application\Cms\Controllers\Controller as Controller;


use Dhcd\Administration\App\Repositories\ProvineCityRepository;
use Dhcd\Administration\App\Models\ProvineCity;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ProvineCityController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số",
        'unique' => "Phải duy nhất"
    );

    public function manage()
    {   
        return view('DHCD-ADMINISTRATION::modules.administration.provine-city.manage');
    }

    public function __construct(ProvineCityRepository $provineCityRepository)
    {
        parent::__construct();
        $this->provine_city = $provineCityRepository;
    }

    public function create()
    {
        return view('DHCD-ADMINISTRATION::modules.administration.provine-city.create');
    }

    public function add(ProvineCityRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:200',
            'code' => 'required|unique:dhcd_provine_city,code',
            'type' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $type = $request->input('type'); 
            $name = $request->input('name');
            $provine_citys = new ProvineCity();
            $provine_citys->create_by = $this->user->email; 
            $provine_citys->name = $name; 
            $provine_citys->alias = self::stripUnicode($name);
            $provine_citys->type = $type; 
            if($type == 'tinh'){   
                $provine_citys->name_with_type = 'Tỉnh '.$name; 
            }
            else{
                $provine_citys->name_with_type = 'Thành phố '.$name;     
            }
            $provine_citys->code = $request->code; 
            $provine_citys->created_at = new DateTime();
            $provine_citys->updated_at = new DateTime();
            $provine_citys->save();
            if ($provine_citys->provine_city_id) {
                activity('provine_city')
                    ->performedOn($provine_citys)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add Provice City - name: :properties.name, provine_city_id: ' . $provine_citys->provine_city_id);

                return redirect()->route('dhcd.administration.provine-city.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.administration.provine-city.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages(); 
        }
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'provine_city_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $provine_city_id = $request->input('provine_city_id');
            $provine_city = $this->provine_city->find($provine_city_id);
            if(empty($provine_city)){
                return redirect()->route('dhcd.administration.provine-city.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));
            }
            $data = [
                'provine_city' => $provine_city
            ];
            return view('DHCD-ADMINISTRATION::modules.administration.provine-city.edit', $data);
        } else {
            return $validator->messages();     
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:200',
            'type' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $provine_city_id = $request->input('provine_city_id');
            $name = $request->input('name');
            $type = $request->input('type');
            $provine_city = $this->provine_city->find($provine_city_id);
            $provine_city->name = $request->input('name'); 
            $provine_city->alias = self::stripUnicode($name);
            $provine_city->type = $type ; 
            if($type == 'tinh'){   
                $provine_city->name_with_type = 'Tỉnh ' . $name; 
            }
            else{
                $provine_city->name_with_type = 'Thành phố ' . $name;     
            }
            $provine_city->updated_at = new DateTime();
            if ($provine_city->save()) {
                activity('provine_city')
                    ->performedOn($provine_city)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update Provine City - provine_city_id: :properties.provine_city_id, name: :properties.name');

                return redirect()->route('dhcd.administration.provine-city.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.administration.provine-city.show', ['provine_city_id' => $request->input('provine_city_id')])->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.update'));
            }
        }
        else{
            return $validator->messages();   
        }
    }

    public function getModalDelete(ProvineCityRequest $request)
    {
        $model = 'provine_city';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'provine_city_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.administration.provine-city.delete', ['provine_city_id' => $request->input('provine_city_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {   
        $validator = Validator::make($request->all(), [
            'provine_city_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            $provine_city_id = $request->input('provine_city_id');
            $provine_city = $this->provine_city->find($provine_city_id);
            
            if (null != $provine_city) {
                $this->provine_city->delete($provine_city_id);
                activity('provine_city')
                    ->performedOn($provine_city)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Delete Provine City - provine_city_id: :properties.provine_city_id, name: ' . $provine_city->name);

                return redirect()->route('dhcd.administration.provine-city.manage')->with('success', trans('DHCD-ADMINISTRATION::language.messages.success.delete'));
            } else {
                return redirect()->route('dhcd.administration.provine-city.manage')->with('error', trans('DHCD-ADMINISTRATION::language.messages.error.delete'));
            }
        } else {
            return $validator->messages();    
        }
    }
    
    public function log(Request $request)
    {
        $model = 'provine_city';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric'
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('provine_city_id')]
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
        $provine_city = $this->provine_city->all();
        return Datatables::of($provine_city)
            ->addIndexColumn()
            ->addColumn('actions', function ($provine_city) {
                $actions = '';
                if ($this->user->canAccess('dhcd.administration.provine-city.log')) {
                    $actions .= '<a href=' . route('dhcd.administration.provine-city.log', ['type' => 'provine-city', 'id' => $provine_city->provine_city_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log provine-city"></i></a>';
                }
                if ($this->user->canAccess('dhcd.administration.provine-city.show')) {
                    $actions .= '<a href=' . route('dhcd.administration.provine-city.show', ['provine_city_id' => $provine_city->provine_city_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update provine-city"></i></a>';
                }
                if ($this->user->canAccess('dhcd.administration.provine-city.confirm-delete')) {
                    $actions .= '<a href=' . route('dhcd.administration.provine-city.confirm-delete', ['provine_city_id' => $provine_city->provine_city_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete provine-city"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }
    
    public function checkCode(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $provine_city =  ProvineCity::where(['code' => $request->input('code')])->first();
            if ($provine_city) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function apiList(Request $request){
        $provine_citys =  $this->provine_city->all();
        $list_provine_city = array();
        foreach ($provine_citys as $key => $value) {
            $list_provine_city[] = [
                'provine_city_id' => $value->provine_city_id,
                'name' => $value->name
            ];   
        } 
        return json_encode($list_provine_city);  
    }
}
