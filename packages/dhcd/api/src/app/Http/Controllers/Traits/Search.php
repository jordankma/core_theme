<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Validator;
use Cache;

trait Search
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getSearch($request){
        $key_word = $request->keyword;
        $members = [
            0 => [
                'member_id' => 20,
                'name' => base64_encode('Lê Văn A')
            ],
            1 => [
                'member_id' => 21,
                'name' => base64_encode('Lê Văn B')
            ],
            2 => [
                'member_id' => 22,
                'name' => base64_encode('Lê Văn C')
            ]
        ];
        $groups = [
            0 => [
                'group_id' => 1,
                'name' => base64_encode('An Giang')
            ],
            1 => [
                'group_id' => 10,
                'name' => base64_encode('Bắc Giang')
            ],
            2 => [
                'group_id' => 11,
                'name' => base64_encode('Bắc Ninh')
            ]
        ];
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

}