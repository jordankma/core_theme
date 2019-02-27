<?php

namespace Vne\Hocvalamtheobac\App\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Auth,Cookie;
use GuzzleHttp\Client;
class VerifyContest
{
	// private $header = ;
    public function handle($request, Closure $next)
    {
		$url = config('app.url');
		// $url = 'http://gthd.vnedutech.vn';
		if(!$request->has('token')){
			return redirect("http://eid.vnedutech.vn/login?site=" . $url);	
		}
		$token = $request->input('token');
		$check_login = false; //da login chua
		$check_reg = false; //da dang ky thong tin chua
		$type_exam = $request->input('type_exam','real');
		
		// try {
		// 	$client = new Client([
		// 		'headers'  => [
		// 			'Authorization' => 'Bearer ' . env('BEARER_TOKEN'),
		// 			'Accept' => 'application/json'
		// 	]]);
		// 	$res = $client->get('http://eid.vnedutech.vn/api/verify?token=' . $token);
		// 	$data_reponse_eid = json_decode($res->getBody(),true);
		// 	if($data_reponse_eid['success'] == true){
		// 		$check_login =	true;
		// 		$member_id = $data_reponse_eid['data']['user_id'];
		// 	}
		// } catch (\Throwable $th) {
		// 	throw $th;
		// }
		$member_id = Cookie::get('member_id');
		$check_login =	true;
		if($check_login == false){
			return redirect("http://eid.vnedutech.vn/login?site=" . $url);		
		} else {
			try {
				$data_reponse = json_decode(file_get_contents($url . '/api/contest/get/check_reg?member_id=' . $member_id),true);
				if($data_reponse['success'] == true){
					$check_reg = true;		 		
				}
			} catch (\Throwable $th) {
				//throw $th;
			}
			if($check_reg == true){
				if($type_exam == 'real'){
					//check auto close contest
					$type_exam = 'real';
					$data_tmp = json_decode(self::checkEndExam($type_exam),true);
					$arr_pass = [4098680,12493754];
					if($data_tmp['status'] == false && !in_array($member_id,$arr_pass)){
						$messages = $data_tmp['messages'];
						return view('VNE-HOCVALAMTHEOBAC::modules.contest.notification',compact('messages', $messages));
					}
					//end
				}
				$request->merge([ 'member_id' => $member_id , 'check_reg' => $check_reg]);
				return $next($request);
			} else{
				return redirect()->route('frontend.member.register.show',['member_id' => $member_id]);		
			}
		}
        return redirect()->route('index');
    }
	function checkEndExam($type_exam){
		$url = config('app.url');
		// $url = 'http://gthd.vnedutech.vn';
		$status = false;
		$messages = 'Vòng thi kết thúc!';
		try {
			$data_reponse = json_decode(file_get_contents($url . '/api/contest/get/exam_info?type=' . $type_exam),true);
			$rounds = $data_reponse['data']['exam_info']['round'];
			$current_time = time();
			if(!empty($rounds)){
				foreach ($rounds as $key => $value) {
					$topics = $value['topic'];
					if(!empty($topics)){
						foreach ($topics as $key2 => $value2) {
							$time = $value2['time'];
							if($time['start'] <= $current_time && $time['end'] >= $current_time){
								$status = true;			
								$messages = $time['end_notify'];	
							}	
						}
					}
				}
			}
		} catch (\Throwable $th) {
			//throw $th;
		}
		$data = [
			'status' => $status,
			'messages' => $messages
		];
		return json_encode($data);	
	}
}