<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Validator;
use Cache;

use Dhcd\Member\App\Elastic\GroupElastic;
use Dhcd\Member\App\Elastic\MemberElastic;
trait Search
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getSearch($request){
        $keyword = $this->to_slug($request->keyword);
        $params = [
            'name' => $keyword
        ];
        $group = new GroupElastic();
        $data_groups = $group->customSearch($params)->paginate(20);
        $member = new MemberElastic();
        $data_members = $member->customSearch($params)->paginate(20);
        $groups = $members = array();
        if(count($data_groups)>0){
            foreach ($data_groups as $key => $group) {
                $groups[] = [
                    'group_id' => $group->group_id,
                    'name' => base64_encode($group->name)
                ];   
            }
        }
        if(count($data_members)>0){
            foreach ($data_members as $key => $member) {
                $members[] = [
                    'member_id' => $member->member_id,
                    'name' => base64_encode($member->name)
                ];   
            }
        }
        $data = '{
                    "data": {
                        "members": '. json_encode($members) .',
                        "groups": '. json_encode($groups) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    protected function to_slug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', ' ', $str);
        return $str;
    }

}