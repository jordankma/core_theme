<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

use GuzzleHttp\Client;
use Vne\Hocvalamtheobac\App\ApiHash;

class MemberController extends Controller
{
    protected $secret_key = '8bgCi@gsLbtGhO)1';
    protected $secret_iv = ')FQKRL57zFYdtn^!';
    protected $url_api_prefix;
    private $register_form;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    
    function setJsonRegisterForm(){
//      $this->register_form = file_get_contents($this->url . '/api/contest/get/load_form');
      $this->register_form = file_get_contents($this->url . '/api/contest/get/load_form');
    }
    function setUrlApiPrefix(){
      $this->url_api_prefix = $this->url . config('site.api_prefix');   
    }
    public function __construct()
    {
       
        parent::__construct();
        Session::put('url.intended', URL::full());
        $this->setUrlApiPrefix();
        $this->setJsonRegisterForm();
    }

    public function showRegisterMember(Request $request){
        if(env('GTHD_OPEN',false) == false){
          return redirect()->route('index');
        }
        $url = $this->url;
        $register_form = $this->register_form;
        $register_form_array = json_decode($register_form,true);
        //render form default
        $form_data = $register_form_array['data']['load_default'];
        $autoload = $register_form_array['data']['auto_load'];
        if(!empty($request->type) && ($request->type == 'app')) {
            $validator = Validator::make($request->all(), [
                'token' => 'required'
            ], $this->messages);
            if (!$validator->fails()) {

                $client = new Client();
                $headers = [
                    'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
                    'Accept' => 'application/json',
                ];
                try {
                    $verify_res = $client->request('GET', 'http://eid.vnedutech.vn/api/verify?token=' . $request->token, [
                        'headers' => $headers
                    ])->getBody()->getContents();
                }
                catch (\Exception $e) {

                }
                if (!empty($verify_res)) {
                    $verify_res = json_decode($verify_res);
                    if ($verify_res->success == true) {
                        if (!empty($verify_res->data->user_id) && !empty($verify_res->data->username)) {
                            $data_reponse = json_decode(file_get_contents($url . '/api/contest/get/check_reg?member_id=' . $verify_res->data->user_id),true);
                            if($data_reponse['success'] == true){
                                return redirect()->route('index');
                            }
                            else{
                                $html = view('VNE-HOCVALAMTHEOBAC::modules.member.input', compact('form_data','autoload'));
                                $form_data_default = $html->render();
                                //end
                                $data = [
                                    'autoload' => $autoload,
                                    'config' => $register_form_array['config'],
                                    'form_data_default' => $form_data_default,
                                    'member_id' => $verify_res->data->user_id,
                                    'u_name' => $verify_res->data->username,
                                    'token' => $request->token
                                ];
                                // dd($register_form_array['data']['auto_load']);
                                return view('VNE-HOCVALAMTHEOBAC::modules.member.register_app',$data);
                            }

                        }
                        else{
                            echo '<pre>';print_r('misssing something');echo '</pre>';die;
                        }
                    }
                    else{
                        return redirect()->route('index');
                    }
                }
            }
            else{
                return redirect()->route('index');
            }
        }
        else{
            $validator = Validator::make($request->all(), [
                'member_id' => 'required|numeric'
            ], $this->messages);
            if (!$validator->fails()) {
                $member_id = $request->input('member_id');
                $check_reg = $request->input('check_reg');

                // $url = 'http://gthd.vnedutech.vn';
                if($check_reg == null){
                    $data_reponse = json_decode(file_get_contents($url . '/api/contest/get/check_reg?member_id=' . $member_id),true);
                    if($data_reponse['success'] == true){
                        $check_reg = true;
                    }
                }
                if($check_reg == true){
                    return redirect()->route('index');
                }
                $html = view('VNE-HOCVALAMTHEOBAC::modules.member.input', compact('form_data','autoload'));
                $form_data_default = $html->render();
                //end
                $data = [
                    'autoload' => $autoload,
                    'config' => $register_form_array['config'],
                    'form_data_default' => $form_data_default
                ];
                // dd($register_form_array['data']['auto_load']);
                return view('VNE-HOCVALAMTHEOBAC::modules.member.register',$data);
            } else{
                return redirect()->route('index');
            }
        }
    }

    public function getFormRegister(Request $request){
      // return redirect()->route('index');
      $validator = Validator::make($request->all(), [
            'key' => 'required|numeric',
            'key2' => 'required|numeric'
        ], $this->messages);
        if (!$validator->fails()) {
          $key = $request->input('key');
          $key2 = $request->input('key2');
          // $this->getRegisterForm();
          $register_form = $this->register_form;
          $register_form_array = json_decode($register_form,true);
          if(!empty($register_form_array)){
            $form_data = $register_form_array['data']['auto_load'][$key]['form_data'][$key2]['form_data'];
          }
          $str = '';
          if(count($form_data) > 0){
            $html = view('VNE-HOCVALAMTHEOBAC::modules.member.input', compact('form_data'));
            $str = $html->render();
          }
          return response()->json(['str'=>$str]);
        } else {
          return $validator->messages();
        }        
    }
    public function getFormRegister2(Request $request){
        // return redirect()->route('index');
        $validator = Validator::make($request->all(), [
            'key' => 'required|numeric',
            'key2' => 'required|numeric'
        ], $this->messages);
        if (!$validator->fails()) {
            $key = $request->input('key');
            $key2 = $request->input('key2');
            $key3 = $request->input('key3');
            // $this->getRegisterForm();
            $register_form = $this->register_form;
            $register_form_array = json_decode($register_form,true);
            if(!empty($register_form_array)){
                $form_data = $register_form_array['data']['auto_load'][$key]['form_data'][$key2]['form_data'][0]['data_view'][$key3]['field'];
//                $form_data = $register_form_array['data']['auto_load'][$key]['form_data'][$key2]['form_data'];
            }
            $str = '';
            if(count($form_data) > 0){
                $html = view('VNE-HOCVALAMTHEOBAC::modules.member.input', compact('form_data'));
                $str = $html->render();
            }
            return response()->json(['str'=>$str]);
        } else {
            return $validator->messages();
        }
    }

    public function updateRegisterMember(Request $request){
        if(env('GTHD_OPEN',false) == false){
            return redirect()->route('index');
        }
        try{
            $load_form = file_get_contents(config('app.url').'/api/contest/get/load_form');
        }
        catch(\Exception $e){

        }
        if(!empty($load_form)){
            $load_form = json_decode($load_form);
            $default = $load_form->data->load_default;
            $target = $load_form->data->auto_load;
            if(!empty($default)){
                foreach ($default as $key4 => $item4){
                    if($item4->is_require == 1){
                        $item_key = $item4->params;
                        if(empty($request->$item_key)){
                            return redirect()->back()->with('error', "Vui lòng cập nhật đủ thông tin!");
                        }
                    }
                }
            }
            if(!empty($target[0])){
                if(empty($request->target)){
                    return redirect()->back()->with('error', "Vui lòng cập nhật đủ thông tin!");
                }
                else{
                    $target = $target[0]->form_data;
                    foreach ($target as $key5 => $value5){
                        if($value5->id == $request->target){
                            $fields = $value5->form_data;
                            foreach ($fields as $key6 => $value6){
                                $field_param = $value6->params;
                                if(empty($request->$field_param)){
                                    return redirect()->back()->with('error', "Vui lòng cập nhật đủ thông tin!");
                                }
                                if ($value6->type == 'auto') {
                                    $sub_fields = $value6->data_view;
                                    foreach ($sub_fields as $key7 => $value7){
                                        if($value7->params == $request->$field_param){
                                            $sub_params = $value7->field;
                                            if(!empty($sub_params)){
                                                foreach ($sub_params as $key8 => $value8){
                                                    $s_param = $value8->params;
                                                    if(empty($request->$s_param)){
                                                        return redirect()->back()->with('error', "Vui lòng cập nhật đủ thông tin!");
                                                    }
                                                    if(!empty($value8->params_hidden) && ($value8->params_hidden != "")){
                                                        $param_hidden = $value8->params_hidden;
                                                        if(empty($request->$param_hidden)){
                                                            return redirect()->back()->with('error', "Vui lòng cập nhật đủ thông tin!");
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                }
                                else {
                                    if(!empty($value6->params_hidden) && ($value6->params_hidden != "")){
                                        $param_hidden = $value6->params_hidden;
                                        if(empty($request->$param_hidden)){
                                            return redirect()->back()->with('error', "Vui lòng cập nhật đủ thông tin!");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }

        }

        // $date_birthday = new DateTime($request->input('birthday'));
        // $birthday = date_format($date_birthday,"d-m-Y");
        $birthday = $request->input('birthday');
        $field_list = file_get_contents($this->url . '/api/contest/get/list_field');
        $field_list_arr = json_decode($field_list,true);
        $data_request = $request->all();
        if(!empty($data_request) && !empty($field_list_arr)){
            foreach ($data_request as $key => $value) {
                foreach ($field_list_arr as $key2 => $value2) {
                    if($key2 == $key){
                        if($value2 == 'integer'){
                            $data_request[$key] = (int)$value;
                        }
                    }
                }
            }
        }
        $member_id = (int)$request->input('member_id');
        $data_request['birthday'] = $birthday;
        $data_request['member_id'] = $member_id;
        $data_request['email'] = $request->input('email');
        $data_request['phone'] = $request->input('phone');
        $data_request['u_name'] = $request->input('u_name');
        $data_request['token'] = $request->input('token');
        $data_request['created_time'] = time();
        $data = json_encode($data_request);
        $data_encrypt = $this->my_simple_crypt($data);
        $client = new Client();
        $url = $this->url;
        $res = $client->request('POST', $url.'/api/contest/post/candidate_register', [
            'form_params'=> [
                'data' => $data_encrypt
            ]
        ]);
        $data = json_decode($res->getBody(),true);
        if($data['success'] == true){
            return redirect()->route('index');
        } else if ($data['success'] == false) {
            $messages = isset($data['messages']) ? $data['messages'] : '';
            $data = [
                'messages' => $messages
            ];
            return redirect()->route('frontend.member.register.show',['member_id' => $member_id])->with('messages' , $messages);
        }
    }

    function my_simple_crypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = env('SECRET_KEY');
        $secret_iv = env('SECRET_IV');
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = substr( hash( 'sha256', $secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
        return $output;
    }
}
