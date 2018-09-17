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
                        "domain" : "release.dhcd.vnedutech.vn"
                    }
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getConfigText()
    {
        //get domain
//        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
//        $cache_domain = 'data_api_domain_' . $host;
//        if (Cache::has($cache_domain)) {
//            $domain_id = Cache::get($cache_domain);
//        } else {
//            $domain_id = 0;
//            if ($host) {
//                $domain = Domain::where('name', $host)->first();
//                if (null != $domain) {
//                    $domain_id = $domain->domain_id;
//                }
//            }
//            $expiresAt = now()->addDays(5);
//            Cache::put($cache_domain, $domain_id, $expiresAt);
//        }

        //get cache
        $domain_id= 30;
        $cache_data = 'data_api_settings_config_text_' . $domain_id;
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

            $settings = SettingModel::where('domain_id', $domain_id)->get();
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
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getVersion()
    {
        //get domain
//        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
//        $cache_domain = 'data_api_domain_' . $host;
//        if (Cache::has($cache_domain)) {
//            $domain_id = Cache::get($cache_domain);
//        } else {
//            $domain_id = 0;
//            if ($host) {
//                $domain = Domain::where('name', $host)->first();
//                if (null != $domain) {
//                    $domain_id = $domain->domain_id;
//                }
//            }
//            $expiresAt = now()->addDays(5);
//            Cache::put($cache_domain, $domain_id, $expiresAt);
//        }

        //get cache
        $domain_id= 30;
        $cache_data = 'data_api_settings_versions_' . $domain_id;
        if (Cache::has($cache_data)) {
            $data = Cache::get($cache_data);
        } else {

            $settings = SettingModel::where('domain_id', $domain_id)->get();
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
                        "path": "https://static.dhcd.vnedutech.vn/apk/app-debug.apk",
                        "current_time": "' . time() * 1000 . '"
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);

            //put cache
            $expiresAt = now()->addDays(5);
            Cache::put($cache_data, $data, $expiresAt);
        }

        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}