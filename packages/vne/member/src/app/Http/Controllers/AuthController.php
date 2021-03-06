<?php

namespace Vne\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Session;
use GuzzleHttp\Client;
class AuthController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $header = [
        'headers'  => [
            'Authorization' => 'Bearer NGLPs5oUP1gcJISvUy5cA29bMSLHPWoM4MVIEJVr',
            'Accept' => 'application/json'
    ]];
    public function login(Request $request){
        $data['status'] = false;
        $data['messeger'] = 'Tài khoản hoặc mật khẩu sai';
        $email = $request->input('email');
        $password = $request->input('password');
        $data_reponse = $this->getTokenUser($email,$password);
        if($data_reponse['success'] == false) {
            return json_encode($data);
        } else {
            if(Session::has('token_user')) {
                $token = Session::get('token_user');
                $data['status'] = true;
                return json_encode($data);
            }
        }
        return json_encode($data);
    }

    public function register(Request $request){
        $u_name = $request->input('u_name');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $password = $request->input('password');
        $conf_password = $request->input('conf_password');
        $client = new Client($this->header);
        $res = $client->post('http://eid.vnedutech.vn/api/register', [
            'form_params'=> [
                'username' => $u_name,
                'phone' => $phone != null ? $phone : '',
                'email' => $email != null ? $email : '',
                'password' => $password,
                'password_confirmation' => $conf_password,
                'site' => config('app.url')
            ]
        ]);
        $data_reponse = json_decode($res->getBody(),true);
        if($data_reponse['success'] == true){
            // $token = $data_reponse['data']['token'];
            // if(isset($data_reponse['data']['type']) && $data_reponse['data']['type'] == 'phone'){
            //     Session::put('token_user', $token); 
            // }
            $data['user_id'] = isset($data_reponse['data']['user_id']) ? $data_reponse['data']['user_id'] : 1010;
            $data['username'] = isset($data_reponse['data']['username']) ? $data_reponse['data']['username'] : 'default';
            $data['status'] = true;
            return json_encode($data);
        }
        elseif($data_reponse['success'] == false){

            $data['status'] = false;
            $data['messeger'] = 'Có lỗi xảy ra mời bạn kiểm tra thông tin ở trên!';
            if(!empty($data_reponse['data'])){ 
                foreach ($data_reponse['data'] as $key => $value) {
                    $data['messeger'] = $value[0];
                    break;        
                } 
            }
            return json_encode($data);   
        }
        return $data;  
    } 

    public function logout(Request $request){
        if(Session::has('token_user')) {
            Session::forget('token_user');
        }    
        return redirect()->route('index');    
    }
    public function setSession(Request $request){
        $token = $request->input('token');
        // Session::put('token_user',$token);
        return redirect()->intended(route('index'));
    }
    function getTokenUser($email,$password){
        $client = new Client($this->header);
        $res = $client->request('POST', 'http://eid.vnedutech.vn/api/login', [
            'form_params'=> [
                'email' => $email,
                'password' => $password
            ]
        ]);
        $data = json_decode($res->getBody(),true);
        if($data['success'] == true){
            Session::put('token_user', $data['data']['token']);   
        }
        return $data;
    }
    
    //return info user 
    // function getInfoUser($token){
    //     $client = new Client($this->header);
    //     $res = $client->request('POST', 'http://eid.vnedutech.vn/api/authorize', [
    //         'form_params'=> [
    //             'token' => $token
    //         ]
    //     ]); 
    //     $data = json_decode($res->getBody(),true);
    //     if($data['success'] == true){ 
    //         $data_user = $data['data']['user'];  
    //     }
    //     return $data_user;
    // }

}
