<?php

namespace Vne\Theme\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth;
use GuzzleHttp\Client;
class VerifyContest
{
	// private $header = ;
    public function handle($request, Closure $next)
    {
		if(!$request->has('token')){
			return redirect()->route('index');	
		}
		$token = $request->input('token');
		$url = config('app.url');
		// $url = 'http://gthd.vnedutech.vn';
		$check_login = false; //da login chua
		$check_reg = false; //da dang ky thong tin chua
		try {
			$client = new Client([
				'headers'  => [
					'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
					'Accept' => 'application/json'
			]]);
			$res = $client->get('http://eid.vnedutech.vn/api/verify?token=' . $token);
			$data_reponse_eid = json_decode($res->getBody(),true);
			if($data_reponse_eid['success'] == true){
				$check_login =	true;
				$member_id = $data_reponse_eid['data']['user_id'];
			}
		} catch (\Throwable $th) {
			throw $th;
		}
		// dd($check_login);
		if($check_login == false){
			return redirect("http://eid.vnedutech.vn/login?site=" . $url);		
		} else {
			try {
				$data_reponse = json_decode(file_get_contents($url . '/api/contest/get/check_reg?member_id=' . $member_id),true);
				if($data_reponse['status'] == true){
					$check_reg = true;	
				}
			} catch (\Throwable $th) {
				//throw $th;
			}
			// dd($check_reg);
			if($check_reg == true){
				$request->merge([ 'member_id' => $member_id , 'check_reg' => $check_reg]);
				return $next($request);
			} else{
				return redirect()->route('frontend.member.register.show',['member_id' => $member_id]);		
			}
		}
        return redirect()->route('index');
    }

}