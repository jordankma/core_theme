<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Validator;
use Cache;

trait Setting
{
    public function getVersionNav()
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