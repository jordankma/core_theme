<?php

namespace Contest\Contestmanage\App\Http\Controllers;

use Adtech\Application\Cms\Controllers\Controller as Controller;
use Contest\Contestmanage\App\ApiHash;
use Contest\Contestmanage\App\Models\ContestTarget;
use Contest\Contestmanage\App\Repositories\ContestTargetRepository;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Validator;

class ContestTargetController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric' => "Phải là số"
    );
    private $token = 'NGLPs5oUP1gcJISvUy5cA29bMSLHPWoM4MVIEJVr';

    public function __construct(ContestTargetRepository $targetRepository)
    {
        parent::__construct();
        $this->target = $targetRepository;
    }

    public function show(Request $request)
    {
        $city = [];
        $target = ContestTarget::first();
        if(empty($target)){
            $target = new ContestTarget();
            $target->_id = 1;
            $target->city = [
                [
                    "id"=> 62,
                    "name" => "Đăk Nông"
                ]
            ];
            $target->district = [];
            $target->school = [];
            $target->g_class = [];
            $target->gender = 'all';
            $target->age = [];
            $target->save();
        }
        $client = new Client(config('site.url_cuocthi').'/resource/dev/get/vne/getprovince');
        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept'        => 'application/json',
        ];

        $city_list = $client->request('GET', 'bar', [
            'headers' => $headers
        ]);
        if(!empty($city_list)){
            $city_list = json_decode($city_list,true);
            $arr_city = $city_list['data'];
            foreach ($arr_city as $key => $value){
                $city[$value['_id']] = $value['province'];
            }
        }

        $data = [
            'target' => $target,
            'city' => $city,
            'gender' => [
                'all' => "Tất cả",
                'male' => "Nam",
                'fermale' => 'Nữ'
            ],

        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_target.edit', $data);
    }

    public function getHtmlType(){
        $data_type = file_get_contents(config('site.url_cuocthi').'/api/contest/get/type_config');
        $res = [
            'html_type' => [],
            'type' => []
        ];

        if(!empty($data_type)){
            $data_type = json_decode($data_type, true);
            if(!empty($data_type['data'])){
                $res['html_type'] = $data_type['data']['html_type_list'];
                $res['type'] = $data_type['data']['type'];
            }
        }
        return $res;

    }

    public function manage(Request $request)
    {
        $field_list = file_get_contents(config('site.url_cuocthi').'/resource/'.(new ApiHash(env('SECRET_KEY'),env('SECRET_IV')))->encrypt('dev/get/user_field?time='.(time()*1000)));
        if(!empty($field_list)){
            $flist = json_decode($field_list,true);
            $field_list = [];
            foreach ($flist as $key => $value){
                $field_list[$value['field_id']] = $value;
            }
        }
//        $city = [];
        $target = ContestTarget::first();
    //get data province (api with bearer)
//        $api = 'http://cuocthi.vnedutech.vn/resource/dev/get/vne/getallprovince';
//        $headers = [
//            'Authorization' => 'Bearer ' . $this->token,
//            'Accept'        => 'application/json',
//        ];
//        $city_list = ((new Client())->request('GET',$api, ['headers' => $headers]))->getBody()->getContents();
    //end
//        if(!empty($city_list)){
//            $city_list = json_decode($city_list,true);
//            $arr_city = $city_list['data'];
//            foreach ($arr_city as $key => $value){
//                $city[$value['_id']] = $value['province'];
//            }
//        }

        $data = [
            'target' => $target,
//            'city' => $city,
            'gender' => [
                'all' => "Tất cả",
                'male' => "Nam",
                'fermale' => 'Nữ'
            ],
            'field_list' => $field_list,
            'html_type_list' => ($this->getHtmlType())['html_type'],
            'type' => ($this->getHtmlType())['type'],

        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.contest_target.manage', $data);
    }

    public function getAdministrativeData(Request $request){

        if(!empty($request->type)){
            if($request->type == 'district'){
                if(!empty($request->city_id)){
                    $res = json_decode(file_get_contents(config('site.url_cuocthi').'/admin/vne/getdistricts/' . $request->city_id));
                }
            }
        }
        return response()->json($res);
    }

    public function update(Request $request)
    {
        $field_list = file_get_contents(config('site.url_cuocthi').'/resource/'.(new ApiHash(env('SECRET_KEY'),env('SECRET_IV')))->encrypt('dev/get/user_field?time='.(time()*1000)));
        $data_type = file_get_contents(config('site.url_cuocthi').'/api/contest/get/type_config');
        $html_type = [];
        $type = [];
        if(!empty($data_type)){
            $data_type = json_decode($data_type, true);
            if(!empty($data_type['data'])){
                $html_type = $data_type['data']['html_type_list'];
                $type = $data_type['data']['type'];
            }
        }
        if(!empty($field_list)){
            $flist = json_decode($field_list,true);
            $field_list = [];
            foreach ($flist as $key => $value){
                $field_list[$value['field_id']] = $value;
            }
        }
        $contest_target = ContestTarget::first();
        if(empty($contest_target)) {
            $contest_target = new ContestTarget();
        }
        $general = [];
        $target = [];
        if(!empty($request->general)){
            foreach ($request->general as $key1 => $value1){
                $target_data = $field_list[$value1['field_id']];
                $general[$key1] = new \stdClass();
                $general[$key1]->id = (int)$value1['field_id'];
                $general[$key1]->title = $value1['label'];
                $general[$key1]->order = (int)$value1['order'];
                $general[$key1]->hint_text = $target_data['hint_text'];
                $general[$key1]->params_hidden = !empty($target_data['params_hidden'])?$target_data['params_hidden']:"";
                $general[$key1]->type = $target_data['type'];
                if($target_data['type'] == 'api'){
                    $general[$key1]->api = $target_data['api'];
                    $general[$key1]->parent_field = $target_data['parent_field'];
                }
                elseif($target_data['type'] == 'data_api'){
                    $general[$key1]->type = 'data';
                }
                $general[$key1]->params = $target_data['varible'];
                $general[$key1]->type_view = $target_data['type_name'];
                $general[$key1]->type_id = $target_data['type_id'];
                $general[$key1]->data_type = $target_data['data_type'];
                $general[$key1]->is_require = !empty($value1['is_require'])?true:false;
                $general[$key1]->is_search = !empty($value1['is_search'])?true:false;
                $general[$key1]->show_on_info = !empty($value1['show_on_info'])?true:false;
                $general[$key1]->show_on_result = !empty($value1['show_on_result'])?true:false;
                $general[$key1]->data_view = $target_data['data_view'];
            }
        }

        if(!empty($request->target)){
            foreach ($request->target as $key2 => $value2) {
                $target[$key2] = new \stdClass();
                $target[$key2]->name = $value2['name'];
                $target[$key2]->field = [];
                foreach ($value2['field'] as $key3 => $value3) {
                    $target[$key2]->field[$key3] = new \stdClass();
                    $target_data = $field_list[$value3['field_id']];
                    $target[$key2]->field[$key3]->id = (int)$value3['field_id'];
                    $target[$key2]->field[$key3]->title = $value3['label'];
                    $target[$key2]->field[$key3]->order = (int)$value3['order'];
                    $target[$key2]->field[$key3]->hint_text = $target_data['hint_text'];
                    $target[$key2]->field[$key3]->params_hidden = !empty($target_data['params_hidden'])?$target_data['params_hidden']:"";
                    $target[$key2]->field[$key3]->type = $target_data['type'];
                    if($target_data['type'] == 'api'){
                        $target[$key2]->field[$key3]->api = $target_data['api'];
                        $target[$key2]->field[$key3]->parent_field = $target_data['parent_field'];
                    }
                    elseif($target_data['type'] == 'data_api'){
                        $target[$key2]->field[$key3]->type = 'data';
                    }
                    $target[$key2]->field[$key3]->params = $target_data['varible'];
                    $target[$key2]->field[$key3]->type_view = $target_data['type_name'];
                    $target[$key2]->field[$key3]->type_id = $target_data['type_id'];
                    $target[$key2]->field[$key3]->data_type = $target_data['data_type'];
                    $target[$key2]->field[$key3]->is_require = !empty($value3['is_require'])?true:false;
                    $target[$key2]->field[$key3]->is_search = !empty($value3['is_search'])?true:false;
                    $target[$key2]->field[$key3]->show_on_info = !empty($value3['show_on_info'])?true:false;
                    $target[$key2]->field[$key3]->show_on_result = !empty($value3['show_on_result'])?true:false;
                    $target[$key2]->field[$key3]->data_view = $target_data['data_view'];

                }
            }
        }
        $contest_target->config = $html_type;
        $contest_target->general = $general;
        $contest_target->target = $target;
        try {
            $contest_target->save();
//            activity('target')
//                ->performedOn($contest_target)
//                ->withProperties($request->all())
//                ->log('User: :causer.email - Update season - product_id: :properties.season_id, name: :properties.name');

            return redirect()->route('contest.contestmanage.contest_target.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
//            return redirect()->back()->with('error', trans('contest-contestmanage::language.messages.error.update'));
        }
    }

    public function log(Request $request)
    {
        $model = 'target';
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

//    Quản lý thông tin chung

    public function showGeneralField(){
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.general_field.manage');
    }

    public function createGeneralField(){
        $data_type = file_get_contents('http://cuocthi.vnedutech.vn/api/contest/get/type_config');
        $html_type = [];
        $type = [];
        if(!empty($data_type)){
            $data_type = json_decode($data_type, true);
            if(!empty($data_type['data'])){
                $html_type = $data_type['data']['html_type_list'];
                $type = $data_type['data']['type'];

            }
        }
        $data_view = [
            'html_type' => $html_type,
            'type' => $type,
        ];
        return view('CONTEST-CONTESTMANAGE::modules.contestmanage.general_field.create', $data_view);
    }

    public function addGeneralField(){

    }

    public function deleteGeneralField(){

    }

    public function manageGeneralField(){
        $target = ContestTarget::first();
        if(!empty($target)){
            echo '<pre>';print_r($target);echo '</pre>';die;
        }
        else{
            $field_data = file_get_contents(config('site.url_cuocthi').'/resource/'.(new ApiHash(env('SECRET_KEY'),env('SECRET_IV')))->encrypt('dev/get/user_field?time='.(time()*1000)));
            if(!empty($field_data)){
                $field_data = json_decode($field_data,true);
            }
        }
    }

    public function dataGeneralField(){

    }

    public function getDetailField(Request $request){
        $data_type = file_get_contents(config('site.url_cuocthi').'/api/contest/get/type_config');
        $html_type = [];
        $type = [];
        $type_id = 0;
        if(!empty($data_type)){
            $data_type = json_decode($data_type, true);
            if(!empty($data_type['data'])){
                $html_type = $data_type['data']['html_type_list'];
                $type = $data_type['data']['type'];
            }
        }
        $target = ContestTarget::first();
        $target_type = $request->target_type;
        $key = $request->key;
        $field = [];
        if(!empty($target)){
            if(!empty($target->$target_type)){
                if($target_type == 'general'){
                    foreach ($target->$target_type as $key => $value){
                        if($value['id'] == $request->id){
                            $field = $value;
                        }
                    }
                }
                elseif($target_type == 'target'){
                    $_target = ($target->$target_type)[$key];
                    if(!empty($_target)){
                        foreach ($_target['field'] as $key1 => $value1){
                            if($value1['id'] == $request->id){
                                $field = $value1;
                            }
                        }
                    }
                }
            }
            foreach ($html_type as $key2 => $value2){
                if($value2 == $field['type_view']){
                    $type_id = $key2;
                }
            }
        }
//        echo '<pre>';print_r($field);echo '</pre>';die;
        $data_view = [
            'field' => $field,
            'html_type_list' => $html_type,
            'type_id' => $type_id,
            'id' => $request->id,
            'key' => $key,
            'target_type' => $target_type,
            'type' => $type
        ];
        $html = view('CONTEST-CONTESTMANAGE::modules.contestmanage.includes.field_detail', $data_view)->render();
        return response()->json($html);
    }

    public function updateField(Request $request){
        $target = ContestTarget::first();
        $key = $request->key;
        $id = $request->id;
        $target_type = $request->target_type;
        if(!empty($target->$target_type)){
            $data = $target->$target_type;
//            echo '<pre>';print_r($target->$target_type);echo '</pre>';die;
            if($target_type == 'general'){
                foreach ($data as $key2 => $value2){
                    if($value2['id'] == $id){
                        $data[$key2]['id'] = $request->id;
                        $data[$key2]['title'] = $request->label;
                        $data[$key2]['hint_text'] = $request->hint_text;
                        $data[$key2]['type'] = $request->type;
                        if(!empty($request->type) && ($request->type == 'api')){
                            $data[$key2]['api'] = $request->api;
                        }
                        $data[$key2]['params'] = $request->varible;
                        $data[$key2]['type_view'] = $request->type_name;
                        $data[$key2]['type_id'] = $request->type_id;
                        $data[$key2]['is_require'] = !empty($request->is_require)?true:false;
                        $data[$key2]['is_search'] = !empty($request->is_search)?true:false;
                        $data[$key2]['show_on_info'] = !empty($request->show_on_info)?true:false;
                        $data[$key2]['show_on_result'] = !empty($request->show_on_result)?true:false;
                        if(!empty($request->dataview)){
                            $data_view = [];
                            foreach ($request->dataview['key'] as $key1 => $value1){
                                $data_view[$key1] = [
                                    'key' => $value1,
                                    'value' => $request->dataview['value'][$key1]
                                ];
                            }
                            $data[$key2]['data_view'] = $data_view;
                        }

                    }
                }
            }
            else{

                $field = $data[$key]['field'];
                foreach ($field as $k => $value){
                    if($value['id'] == $id){
//                        echo '<pre>';print_r($value);echo '</pre>';die;
                        $field[$k]['id'] = $request->id;
                        $field[$k]['title'] = $request->label;
                        $field[$k]['hint_text'] = $request->hint_text;
                        $field[$k]['type'] = $request->type;
                        if(!empty($request->type) && ($request->type == 'api')){
                            $field[$k]['api'] = $request->api;
                        }
                        $field[$k]['params'] = $request->varible;
                        $field[$k]['type_view'] = $request->type_name;
                        $field[$k]['type_id'] = $request->type_id;
                        $field[$k]['is_require'] = !empty($request->is_require)?true:false;
                        $field[$k]['is_search'] = !empty($request->is_search)?true:false;
                        $field[$k]['show_on_info'] = !empty($request->show_on_info)?true:false;
                        $field[$k]['show_on_result'] = !empty($request->show_on_result)?true:false;
                        if(!empty($request->dataview)){
                            $data_view = [];
                            foreach ($request->dataview['key'] as $key1 => $value1){
                                $data_view[$key1] = [
                                    'key' => $value1,
                                    'value' => $request->dataview['value'][$key1]
                                ];
                            }
                            $field[$k]['data_view'] = $data_view;
                        }
                    }
                }
                $data[$key]['field'] = $field;
            }
            $target->$target_type = $data;
            if($target->update()){
                return redirect()->route('contest.contestmanage.contest_target.manage')->with('success', trans('contest-contestmanage::language.messages.success.update'));
            }
            else{
                return redirect()->route('contest.contestmanage.contest_target.manage')->with('error', trans('contest-contestmanage::language.messages.eror.update'));
            }
        }
    }

    public function getListField(){
        $target = ContestTarget::first();
        $fields = [];
        if(!empty($target)){
            if(!empty($target->general)){
                foreach ($target->general as $key => $value){
                   $fields[$value['params']] = $value['data_type'];
                }
            }
        }
        if(!empty($target->target)){
            foreach ($target->target as $key1 => $value1){
                foreach ($value1['field'] as $key2 => $value2){
                    $fields[$value2['params']] = $value2['data_type'];
                }
            }
        }
        return response()->json($fields);
    }
}