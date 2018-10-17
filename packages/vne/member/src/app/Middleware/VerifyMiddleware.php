<?php

namespace Vne\Member\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth,Session;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
class VerifyToken
{
    public function handle($request, Closure $next)
    {
    	$USER_INFO = array();
        if(Session::has('token_user')) {
            $token = Session::get('token_user');
            $client = new Client([
		        'headers'  => [
		            'Authorization' => 'Bearer s16W01HQ8En2jeCZNj57asRKGksY6Mcsl2y0vYUb' ,
		            'Accept' => 'application/json'
		    ]]);
	        $res = $client->request('POST', 'http://eid.vnedutech.vn/api/authorize', [
	            'form_params'=> [
	                'token' => $token
	            ]
	        ]); 
	        $data = json_decode($res->getBody(),true);
	        if($data['success'] == true){ 
	        	Session::put('token_user',$data['data']['token']);
	            $USER_INFO = $data['data']['user'];
	        }
        }
     	View::share('USER_INFO',$USER_INFO);
        return $next($request);
    }

}