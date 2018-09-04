<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Adtech\Core\App\Models\Menu as MenuModel;
use Adtech\Core\App\Models\Domain;
use Validator;
use Cache;

trait Menu
{
    public function getMenu()
    {
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $domain_id = $domain->domain_id;
            }
        }

        $cache_name = 'api_menus_frontend_' . $domain_id;
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $menus = Cache::get($cache_name);
        } else {
            $menus = MenuModel::where('domain_id', $domain_id)
                ->where('type', 1)
                ->where('group', 'Left')
                ->where('parent', 0)
                ->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $menus, $expiresAt);
        }

        $list_menus = [];
        $arrTypeData = ['tintuc', 'tailieu'];
        $arrTypeView = ['list', 'detail'];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = base64_encode($menu->name);
                $item->alias = base64_encode($menu->alias);
                $item->icon = base64_encode(config('site.url_storage') . $menu->icon);
                $item->type = in_array($menu->typeData, $arrTypeData) ? base64_encode($menu->typeData) : '';
                $item->typeView = in_array($menu->typeView, $arrTypeView) ? base64_encode($menu->typeView) : '';
                $list_menus[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_info_item_menu": '. json_encode($list_menus) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMenuHome()
    {
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $domain_id = $domain->domain_id;
            }
        }

        $cache_name = 'api_menus_frontend_home_' . $domain_id;
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $menus = Cache::get($cache_name);
        } else {
            $menus = MenuModel::where('domain_id', $domain_id)
                ->where('type', 1)
                ->where('group', 'Home')
                ->where('parent', 0)
                ->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $menus, $expiresAt);
        }

        $list_menus = [];
        $arrTypeData = ['tintuc', 'tailieu'];
        $arrTypeView = ['list', 'detail'];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = base64_encode($menu->name);
                $item->alias = in_array($menu->typeView, $arrTypeView) ? base64_encode($menu->route_params) : base64_encode($menu->alias);
                $item->icon = config('site.url_storage') . $menu->icon;
                $item->type = in_array($menu->typeData, $arrTypeData) ? base64_encode($menu->typeData) : '';
                $item->typeView = in_array($menu->typeView, $arrTypeView) ? base64_encode($menu->typeView) : '';
                $list_menus[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_info_item_menu": '. json_encode($list_menus) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMenuMember()
    {
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $domain_id = $domain->domain_id;
            }
        }

        $cache_name = 'api_menus_frontend_member_' . $domain_id;
        Cache::forget($cache_name);
        if (Cache::has($cache_name)) {
            $menus = Cache::get($cache_name);
        } else {
            $menus = MenuModel::where('domain_id', $domain_id)
                ->where('type', 1)
                ->where('group', 'Member')
                ->where('parent', 0)
                ->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put($cache_name, $menus, $expiresAt);
        }

        $list_menus = [];
        $arrTypeData = ['tintuc', 'tailieu'];
        $arrTypeView = ['list', 'detail'];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = base64_encode($menu->name);
                $item->alias = base64_encode($menu->alias);
                $item->icon = config('site.url_storage') . $menu->icon;
                $item->type = in_array($menu->typeData, $arrTypeData) ? base64_encode($menu->typeData) : '';
                $item->typeView = in_array($menu->typeView, $arrTypeView) ? base64_encode($menu->typeView) : '';
                $list_menus[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_info_item_menu": '. json_encode($list_menus) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}