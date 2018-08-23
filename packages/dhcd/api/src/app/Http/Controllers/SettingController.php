<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Validator;
use Cache;
use Crypt;

class SettingController extends BaseController
{
    public function version()
    {
        $data = '{
                    "data" :{
                        "version": 2
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}