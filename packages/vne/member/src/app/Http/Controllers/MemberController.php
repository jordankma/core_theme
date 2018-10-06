<?php

namespace Vne\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Session;
use GuzzleHttp\Client;
class MemberController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

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
                $data_user = $this->getInfoUser($token);
                Session::put('user_info',  $data_user);
                $data['status'] = true;
                return json_encode($data);
            }
        }
        return json_encode($data);
    }

    public function register(Request $request){

    } 

    public function logout(Request $request){
        if(Session::has('token_user')) {
            $token = $token = Session::get('token_user');
            $client = new Client(['headers'  => ['Authorization' => 'Bearer GYK47oHXhSpHqOuVdhjx6DB478LxGHukNhHis0aR']]);
            $res = $client->request('get', 'http://eid.vnedutech.vn/logout'); 
            Session::forget('user_info');
            return redirect()->route('index');    
        }    
    }
    function getTokenUser($email,$password){
        $client = new Client(['headers'  => ['Authorization' => 'Bearer GYK47oHXhSpHqOuVdhjx6DB478LxGHukNhHis0aR']]);
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
    function getInfoUser($token){
        $client = new Client(['headers'  => ['Authorization' => 'Bearer GYK47oHXhSpHqOuVdhjx6DB478LxGHukNhHis0aR']]);
        $res = $client->request('POST', 'http://eid.vnedutech.vn/api/authorize', [
            'form_params'=> [
                'token' => $token
            ]
        ]); 
        $data = json_decode($res->getBody(),true);
        if($data['success'] == true){ 
            $data_user = $data['data']['user'];  
        }
        return $data_user;
    }

}
