<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Adtech\Core\App\Models\Menu as MenuModel;
use Adtech\Core\App\Models\Domain;
use Validator;
use Cache;

trait Menu
{
    private $__domain_id;
    public function __construct()
    {
        $domain_id = 0;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $domain_id = $domain->domain_id;
            }
        }
        $this->__domain_id = $domain_id;
    }

    public function getMenu()
    {
        $domain_id = $this->__domain_id;
        Cache::forget('api_menus_frontend_' . $domain_id);
        if (Cache::has('api_menus_frontend_' . $domain_id)) {
            $menus = Cache::get('api_menus_frontend_' . $domain_id);
        } else {
            $menus = MenuModel::where('domain_id', $domain_id)
                ->where('type', 1)
                ->where('group', 'Left')
                ->where('parent', 0)
                ->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_menus_frontend_' . $domain_id, $menus, $expiresAt);
        }

        $list_menus = [];
        $arrTypeData = ['tintuc', 'tailieu'];
        $arrTypeView = ['list', 'detail'];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = $menu->name;
                $item->alias = $menu->alias;
                $item->icon = config('site.url_storage') . $menu->icon;
                $item->type = in_array($menu->typeData, $arrTypeData) ? $menu->typeData : '';
                $item->typeView = in_array($menu->typeView, $arrTypeView) ? $menu->typeView : '';
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
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMenuHome()
    {
        $domain_id = $this->__domain_id;
        Cache::forget('api_menus_frontend_home_' . $domain_id);
        if (Cache::has('api_menus_frontend_home_' . $domain_id)) {
            $menus = Cache::get('api_menus_frontend_home_' . $domain_id);
        } else {
            $menus = MenuModel::where('domain_id', $domain_id)
                ->where('type', 1)
                ->where('group', 'Home')
                ->where('parent', 0)
                ->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_menus_frontend_home_' . $domain_id, $menus, $expiresAt);
        }

        $list_menus = [];
        $arrTypeData = ['tintuc', 'tailieu'];
        $arrTypeView = ['list', 'detail'];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = $menu->name;
                $item->alias = $menu->alias;
                $item->icon = config('site.url_storage') . $menu->icon;
                $item->type = in_array($menu->typeData, $arrTypeData) ? $menu->typeData : '';
                $item->typeView = in_array($menu->typeView, $arrTypeView) ? $menu->typeView : '';
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
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMenuMember()
    {
        $domain_id = $this->__domain_id;
        Cache::forget('api_menus_frontend_member_' . $domain_id);
        if (Cache::has('api_menus_frontend_member_' . $domain_id)) {
            $menus = Cache::get('api_menus_frontend_member_' . $domain_id);
        } else {
            $menus = MenuModel::where('domain_id', $domain_id)
                ->where('type', 1)
                ->where('group', 'Member')
                ->where('parent', 0)
                ->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_menus_frontend_member_' . $domain_id, $menus, $expiresAt);
        }

        $list_menus = [];
        $arrTypeData = ['tintuc', 'tailieu'];
        $arrTypeView = ['list', 'detail'];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = $menu->name;
                $item->alias = $menu->alias;
                $item->icon = config('site.url_storage') . $menu->icon;
                $item->type = in_array($menu->typeData, $arrTypeData) ? $menu->typeData : '';
                $item->typeView = in_array($menu->typeView, $arrTypeView) ? $menu->typeView : '';
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
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
}