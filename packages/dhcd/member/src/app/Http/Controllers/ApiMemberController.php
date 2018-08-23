<?php

namespace Dhcd\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Dhcd\Member\App\Http\Requests\ApiMemberRequest;
use Illuminate\Support\Collection;
use Dhcd\Member\App\Models\Member;
use Dhcd\Member\App\Models\Group;

use Dhcd\Member\App\Repositories\MemberRepository;
use Validator,Auth,DB,Hash;

// use Tymon\JWTAuth\Exceptions\JWTException;
// use Tymon\JWTAuth\Facades\JWTAuth;

class ApiMemberController extends BaseController
{	
	private $messages = array(
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
	public function __construct()
    {
        config()->set( 'auth.defaults.guard', 'member' );
    }
	public function postLogin(Request $request){
		$data = [
			"success" => false,
			"message" => "Login thất bại",	
		];
		$validator = Validator::make($request->all(), [
            'u_name' => 'required|min:1|max:200',
            'password' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
			$u_name = $request->u_name;
			$password = $request->password;
			$ret = Auth::guard('member')->attempt(['u_name' => $u_name, 'password' => $password]);
			if (!empty($ret)) {
				// $credentials = $request->only('u_name', 'password');
		  //       try {
		  //           // attempt to verify the credentials and create a token for the user
		  //           if (!$token = JWTAuth::attempt($credentials)) {
		  //               $response['error'] = 'invalid_credentials';
		  //               return response()->json($response, 401);
		  //           }
		  //       } catch (JWTException $e) {
		  //           // something went wrong whilst attempting to encode the token
		  //           $response['error'] = 'could_not_create_token';
		  //           return response()->json($response, 500);
		  //       }
				$member = Auth::guard('member')->user();
				$data = [
					"data" => [
					 	"id"  => $member->member_id,
					 	"avatar" => $member->avatar,
					 	"u_name" => $member->u_name,
					 	"is_files_main_customers" => true,
					 	"email" => $member->email,
					 	"ten_hien_thi" => $member->name,
					 	"token" => [
					 		"token" => 'token'.$member->member_id
					 	]
					],
					"success" => true,
                	"message" => "ok!"
				];
			}
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}
		return response(json_encode($data))->setStatusCode(404)->header('Content-Type', 'application/json; charset=utf-8');
	}

	public function getUserInfo(ApiMemberRequest $request){
		$data = [
			"success" => false,
			"message" => "Lỗi lấy thông tin",	
		];
		$validator = Validator::make($request->all(), [
            'id' => 'required|min:0|numeric',
            'token' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
			$member_id = $request->id;
			$token = $request->token;
			$member = Member::find($member_id);
			// $member = JWTAuth::toUser($request->token);
			if(!empty($member)){
				$member_info = [
					"id" => $member->member_id,
					"anh_ca_nhan" => $member->avatar,
					"ten_hien_thi" => $member->name,
					"email" => $member->email,
					"so_dien_thoai" => $member->phone,
					"doan_thanh_nien" => $member->don_vi,
					"ngay_vao_dang" => $member->ngay_vao_dang,
					"dan_toc" => $member->dan_toc,
					"chuc_vu" => $member->position,
					"ton_giao" => $member->ton_giao,
					"trinh_do_ly_luan" => $member->trinh_do_ly_luan,
					"trinh_do_chuyen_mon" => $member->trinh_do_chuyen_mon,
					"noi_lam_viec" => $member->address 
				];
				$data = [
					"success" => true,
					"message" => "Lấy thông tin thành công",
					"data" => $member_info
				];
				return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
			}
		}
			return response(json_encode($data))->setStatusCode(404)->header('Content-Type', 'application/json; charset=utf-8');	
	}
	public function putChangePass(Request $request){
		$data = [
			"success" => false,
			"message" => "Lỗi đổi mật khẩu"	
		];
		$validator = Validator::make($request->all(), [
            'id' => 'required|min:0|numeric',
            'token' => 'required',
            'old_password' => 'required',
            'new_password' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
			$member_id = $request->id;
			$token = $request->token;
			$old_password = $request->old_password;
			$new_password = $request->new_password;
			$member = Member::find($member_id);
			if(!empty($member)){
				$password = $member->password;
				if (Hash::check($old_password , $password) && $old_password != $new_password){
					Member::where('member_id',$member_id)->update(['password' => bcrypt($new_password)]);
					$data = [
						"success" => true,
						"message" => "Đổi mật khẩu thành công"
					];
					return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
				}
			}
		}
		return response(json_encode($data))->setStatusCode(404)->header('Content-Type', 'application/json; charset=utf-8');	
	}

	public function getRegister(ApiMemberRequest $request){
		$x = 1;
		$limit = $request->limit;
		while($x <= $limit) {
            $data_insert[] = [
                'name' => 'member'.$x,
                'gender' => 'male',
                'u_name' => 'member'.$x,
                'phone' => $x,
                'email' => 'member'.$x.'@gmail.com',
                'password' => bcrypt('123456'),
                'token' => 'token'.$x
            ];
       		$x++;   
		}
		if(DB::table('dhcd_member')->insert($data_insert)){
			echo 'done';
		}	
	}

	public function getListGroup(Request $request){
		$groups = Group::all();
		return $groups;
	}
	public function getListMemberGroup(Request $request) {
		$validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
        	$group_id = $request->input('group_id');
        	$groups = Group::where('group_id',$group_id)->with('getMember')->first();
        	if(!empty($groups)){
        		$list_member = $groups->getMember;
        		$collection = new Collection();
        		$list_member_collection = $collection->push($list_member);
        		return $list_member;
        	}	
        }	
        else {
        	$validator->messages();
        }
	}
}