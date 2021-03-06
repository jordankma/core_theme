<?php

namespace Vne\Theme\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

use GuzzleHttp\Client;
use Vne\Theme\App\ApiHash;

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
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric'
        ], $this->messages);
        if (!$validator->fails()) {
          $member_id = $request->input('member_id');
          $check_reg = $request->input('check_reg');
          $url = $this->url;
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
          $register_form = $this->register_form;
          $register_form_array = json_decode($register_form,true);
          //render form default
          $form_data = $register_form_array['data']['load_default'];
          $autoload = $register_form_array['data']['auto_load'];
          $html = view('VNE-THEME::modules.member.input', compact('form_data','autoload'));
          $form_data_default = $html->render();
          //end
          $data = [
            'autoload' => $register_form_array['data']['auto_load'],
            'config' => $register_form_array['config'],
            'form_data_default' => $form_data_default
          ];
          // dd($register_form_array['data']['auto_load']);
          return view('VNE-THEME::modules.member.register',$data);
        } else{
          return redirect()->route('index');
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
            $html = view('VNE-THEME::modules.member.input', compact('form_data'));
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
      $date_birthday = new DateTime($request->input('birthday'));
      $birthday = date_format($date_birthday,"d-m-Y");
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
