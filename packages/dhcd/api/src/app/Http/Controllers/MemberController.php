<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Dhcd\Member\App\Models\Member;
use Validator;
use Cache;
use Crypt;

class MemberController extends BaseController
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getMember(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'u_id' => 'required|numeric'
//            'token' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $request->input('u_id');
            Cache::forget('api_member_' . $member_id);
            if (Cache::has('api_member_' . $member_id)) {
                $member = Cache::get('api_member_' . $member_id);
            } else {
                $member = Member::find($member_id);
                $expiresAt = now()->addMinutes(3600);
                Cache::put('api_member_' . $member_id, $member, $expiresAt);
            }

            if (null != $member) {
                $item = new \stdClass();
                $item->id = $member->member_id;
                $item->anh_ca_nhan = (self::is_url($member->avata)) ? $member->avata : config('app.url') . '/' . $member->avata;
                $item->ten_hien_thi = $member->name;
                $item->email = $member->email;
                $item->so_dien_thoai = $member->phone;
                $item->ngay_vao_dang = $member->ngay_vao_dang;
                $item->dan_toc = $member->dan_toc;
                $item->chuc_vu = $member->position;
                $item->ton_giao = $member->ton_giao;
                $item->trinh_do_ly_luan = $member->trinh_do_ly_luan;
                $item->trinh_do_chuyen_mon = $member->trinh_do_chuyen_mon;
            }

            $data = '{
                    "data": '. json_encode($item) .',
                    "success" : true,
                    "message" : "ok!"
                }';
            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        } else {
            return $validator->messages();
        }

    }

    function is_url($uri){
        if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$uri)){
            return $uri;
        }
        else{
            return false;
        }
    }
}