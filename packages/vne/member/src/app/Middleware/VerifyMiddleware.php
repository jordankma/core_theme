<?php

namespace Vne\Member\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth,Session,Cookie;
use Illuminate\Cookie\CookieJar;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
class VerifyToken
{
    public function handle($request, Closure $next)
    {
    	$USER_INFO = array();
    	$token = Cookie::get('eids_token');
        if($token != null) {
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
	        // dd($data);
	        if($data['success'] == true){ 
	            $USER_INFO = $data['data']['user'];
	            $token = $data['data']['token'];
	        }
        }
     	View::share('USER_INFO',$USER_INFO);
        return $next($request)->withCookie(cookie('eids_token', $token, 86400 * 30));
    }

}