<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Adtech\Core\App\Models\Setting as SettingModel;
use Adtech\Core\App\Models\Domain;
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

    public function getDomainApi()
    {
        $data = '{
                    "success" : true,
                    "message" : "ok!",
                    "data": {
                        "domain" : "dhcd.vnedutech.vn"
                    }
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getConfigText()
    {
        //get setting value
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $domain_id = $domain->domain_id;
            }
        }

//        Cache::forget('settings' . $domain_id);
        if (Cache::has('settings' . $domain_id)) {
            $settings = Cache::get('settings' . $domain_id);
        } else {
            $settings = SettingModel::where('domain_id', $domain_id)->get();
            Cache::put('settings' . $domain_id, $settings);
        }

        $settingView = array('logo' => '', 'slogan' => '', 'hello_txt' => '');
        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                switch ($setting->name) {
                    case 'logo':
                        $settingView['logo'] = $setting->value;
                        break;
                    case 'slogan':
                        $settingView['slogan'] = $setting->value;
                        break;
                    case 'hello_txt':
                        $settingView['hello_txt'] = $setting->value;
                        break;
                }
            }
        }
        $data = '{
                    "data": {
                        "logo": "' . $settingView['logo'] . '",
                        "slogan": "' . $settingView['slogan'] . '"
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getVersion()
    {
        //get setting value
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $domain_id = $domain->domain_id;
            }
        }

//        Cache::forget('settings' . $domain_id);
        if (Cache::has('settings' . $domain_id)) {
            $settings = Cache::get('settings' . $domain_id);
        } else {
            $settings = SettingModel::where('domain_id', $domain_id)->get();
            Cache::put('settings' . $domain_id, $settings);
        }

        $settingView = array('app_version' => '');
        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                switch ($setting->name) {
                    case 'app_version':
                        $settingView['app_version'] = $setting->value;
                        break;
                }
            }
        }
        $data = '{
                    "data": {
                        "app_version": "' . $settingView['app_version'] . '",
                        "path": "http://dhcd.vnedutech.vn/apk/app-debug",
                        "current_time": "' . time() * 1000 . '"
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
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