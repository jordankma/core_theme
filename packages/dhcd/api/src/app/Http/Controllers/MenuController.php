<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
//use Dhcd\Api\App\Http\Resources\MenuResource;
use Adtech\Core\App\Models\Domain;
use Adtech\Core\App\Models\Menu;
use Cache;
use Crypt;

class MenuController extends BaseController
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
            $menus = Menu::where('domain_id', $domain_id)->where('type', 1)->orderBy('parent')->orderBy('sort')->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_menus_frontend_' . $domain_id, $menus, $expiresAt);
        }

        $list_menus = [];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {
                $item = new \stdClass();
                $item->id = $menu->menu_id;
                $item->title = $menu->name;
                $item->icon = $menu->icon;

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
//         return (MenuResource::collection($menus))->additional(['success' => true, 'message' => 'ok!'])->response()->setStatusCode(200)->setCharset('utf-8');
    }
}