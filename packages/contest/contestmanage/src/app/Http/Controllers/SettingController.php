<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Contest\Contestmanage\App\Models\ContestSetting;
use Dhcd\Contest\App\Repositories\ContestRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class SettingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    private $data_type = [
        'text' => "Text",
        'number' => "Number",
        'array' => "Array"
    ];

    public function add(Request $request)
    {
        $res = [
            'success' => false
        ];
        $setting = new ContestSetting();
        $setting->name = $request->name;
        $setting->param = $request->param;
        $setting->data_type = $request->data_type;
        if ($request->data_type == 'array') {
        $setting->element_number = $request->element_number;
        }

        if ($setting->save()) {
//            activity('cardProduct')
//                ->performedOn($setting)
//                ->withProperties($request->all())
//                ->log('User: :causer.email - Add cardProduct - name: :properties.name, product_id: ' . $setting->product_id);

            $res['success'] = true;
        } else {
            $res['success'] = false;
        }
        return response()->json($res);

    }

    public function create()
    {
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.setting.create');
    }

    public function delete(Request $request)
    {
        $product_id = $request->input('product_id');
        $setting = $this->cardProduct->find($product_id);

        if (null != $setting) {
            $this->cardProduct->delete($product_id);

            activity('cardProduct')
                ->performedOn($setting)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete cardProduct - product_id: :properties.product_id, name: ' . $setting->product_name);

            return redirect()->route('contest.contestmanage.setting.manage')->with('success', trans('contest-contestmanage::language.messages.success.delete'));
        } else {
            return redirect()->route('contest.contestmanage.setting.manage')->with('error', trans('contest-contestmanage::language.messages.error.delete'));
        }
    }

    public function manage()
    {
        $setting = ContestSetting::all();
        $data = [
            'setting' => $setting,
            'data_type' => $this->data_type
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.setting.manage', $data);
    }

    public function show(Request $request)
    {
        $product_id = $request->input('product_id');
        $setting = $this->cardProduct->find($product_id);
        $data = [
            'setting' => $setting,
        ];

        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.setting.edit', $data);
    }

    public function update(Request $request)
    {
      if(!empty($request->param)){
          $setting = ContestSetting::where('param', $request->param)->first();
          if(!empty($setting)){
              if($setting->data_type == 'text'){
                  $setting->data = $request->data;
              }
              elseif($setting->data_type == 'number'){
                  $setting->data = (int)$request->data;
              }
              elseif($setting->data_type == 'array'){
                  if(!empty($request->data['key'])){
                      $arr = [];
                      foreach ($request->data['key'] as $key=>$value) {
                          $arr[$key] = [
                              'key' => $value,
                              'value' => $request->data['value'][$key]
                          ];
                      }
                      $setting->data = $arr;
                  }
              }
              if($setting->update()){
                  return redirect()->route('contest.contestmanage.setting.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
              } else {
                  return redirect()->route('contest.contestmanage.setting.manage')->with('error', trans('contest-contestmanage::language.messages.error.update'));
              }
          }
      }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'cardProduct';
        $tittle='Xác nhận xóa';
        $type=$this->cardProduct->find($request->input('product_id'));
        $content='Bạn có chắc chắn muốn xóa loại: '.$type->product_name.'?';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('contest.contestmanage.setting.delete', ['product_id' => $request->input('product_id')]);
                return view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.modal_confirmation', compact('error','tittle','content', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'cardProduct';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
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
        return Datatables::of($this->cardProduct->findAll())
            ->addColumn('actions', function ($setting) {
                $actions = '<a href=' . route('contest.contestmanage.setting.log', ['type' => 'cardProduct', 'id' => $setting->product_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log cardProduct"></i></a>';
//                        <a href=' . route('contest.contestmanage.setting.confirm-delete', ['product_id' => $setting->product_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete cardProduct"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }


}