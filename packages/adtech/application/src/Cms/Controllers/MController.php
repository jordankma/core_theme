<?php

namespace Adtech\Application\Cms\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Collection;
use Adtech\Core\App\Models\Domain;
use Adtech\Core\App\Models\Menu;
use Adtech\Core\App\Models\Setting;
use Session;
use Cache;
use Auth,URL;
use GuzzleHttp\Client;
use Vne\Companionunit\App\Models\Companionunit;
// Member controller
class MController extends BaseController
{
    use ValidatesRequests;
    protected $user;
    protected $theme;
    protected $currentDomain;
    protected $_menuList;
    protected $_menuTop;
    protected $domainDefault;
    public $url,$list_setting;
    private $header = [
        'headers'  => [
            'X-Requested-With' => 'XMLHttpRequest'
        ]
    ];

    private function _guard()
    {
        return Auth::guard('member');
    }

    public function __construct()
    {
        $id_don_vi_tai_tro = config('site.don_vi_tai_tro_id');
        $list_don_vi_tai_tro = Companionunit::where('comtype',$id_don_vi_tai_tro)->get();
        $this->url = config('app.url');
        $this->url = 'http://hocvalamtheobac.vnedutech.vn';
        $id = $this->_guard()->id();
        $this->theme = config('site.theme');
        $this->user = $this->_guard()->user();
        $email = $this->user ? $this->user->email : null;
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : null;
        $domain_id = 0;
        if ($host) {
            $domain = Domain::where('name', $host)->first();
            if (null != $domain) {
                $this->currentDomain = $domain;
                $domain_id = $domain->domain_id;
            }
        }
        $this->domainDefault = $domain_id;
        if(isset($_GET["domain_id"])) {
            $domain_id = $_GET["domain_id"];
        }
        self::getMenu($this->domainDefault);
        $arrColor = ['#4089C7', '#00BB8D', '#58BEDC', '#F99928', '#F06E6B', '#A7B4BA'];

        //get setting value
        $settings = Setting::where('domain_id', $this->domainDefault)->get();
        $settingView = array('logo' => '', 'logo_mini' => '', 'title' => '', 'favicon' => '', 'logo_link' => '');
        if (count($settings) > 0) {
            foreach ($settings as $setting) {
                switch ($setting->name) {
                    case 'logo':
                        $settingView['logo'] = $setting->value;
                        break;
                    case 'slogan':
                        $settingView['slogan'] = $setting->value;
                        break;
                    case 'logo_mini':
                        $settingView['logo_mini'] = $setting->value;
                        break;
                    case 'title':
                        $settingView['title'] = $setting->value;
                        break;
                    case 'favicon':
                        $settingView['favicon'] = $setting->value;
                        break;
                    case 'logo_link':
                        $settingView['logo_link'] = $setting->value;
                        break;
                    case 'company_name':
                        $settingView['company_name'] = $setting->value;
                        break;
                    case 'address':
                        $settingView['address'] = $setting->value;
                        break;
                    case 'email':
                        $settingView['email'] = $setting->value;
                        break;
                    case 'phone':
                        $settingView['phone'] = $setting->value;
                        break;
                    case 'hotline':
                        $settingView['hotline'] = $setting->value;
                        break;
                    case 'ga_code':
                        $settingView['ga_code'] = $setting->value;
                        break;
                    case 'chat_code':
                        $settingView['chat_code'] = $setting->value;
                        break;
                    case 'info_page_contact':
                        $settingView['info_page_contact'] = $setting->value;
                        break;
                    case 'info_footer_1':
                        $settingView['info_footer_1'] = $setting->value;
                        break;
                    case 'info_footer_2':
                        $settingView['info_footer_2'] = $setting->value;
                        break;
                    case 'info_footer_3':
                        $settingView['info_footer_3'] = $setting->value;
                        break;
                    case 'info_footer_4':
                        $settingView['info_footer_4'] = $setting->value;
                        break;
                    case 'title_timeline':
                        $settingView['title_timeline'] = $setting->value;
                        break;
                    case 'time_timeline':
                        $settingView['time_timeline'] = $setting->value;
                        break;
                    case 'open_fix':
                        $settingView['open_fix'] = $setting->value;
                        break;
                    case 'open_search':
                        $settingView['open_search'] = $setting->value;
                        break;
                }
            }
        }
        $this->list_setting = $settingView; 
        $share = [
            'USER_LOGGED' => $this->user,
            'USER_LOGGED_EMAIL' => $email,
            'USER_LOGGED_ID' => $id,
            'DOMAIN_ID' => $domain_id,
            'MENU_LEFT' => $this->_menuList,
            'MENU_TOP' => $this->_menuTop,
            'COLOR_LIST' => $arrColor,
            'SETTING' => $settingView,
            'group_name'  => config('site.theme'),
            'template'  => config('site.desktop.template'),
            'skin'  => config('site.desktop.skin'),
            'mtemplate'  => config('site.mobile.template'),
            'mskin'  => config('site.mobile.skin'),
            'list_don_vi_tai_tro' => $list_don_vi_tai_tro
        ];
        view()->share($share);
    }

    function getMenu($domain_id = 0) {
        if (Cache::has('menus_frontend_' . $domain_id)) {
            $menus = Cache::get('menus_frontend_' . $domain_id);
        } else {
            $menus = Menu::where('domain_id', $domain_id)->where('group','Web')->where('type', 1)->orderBy('parent')->orderBy('sort')->get();
            Cache::put('menus_frontend_' . $domain_id, $menus);
        }

        $this->_menuTop = [];
        if (count($menus) > 0) {
            foreach ($menus as $menu) {

                $parent_id = $menu->parent;
                $menu_id = $menu->menu_id;

                $menuData['items'][$menu_id] = $menu;
                $menuData['parents'][$parent_id][] = $menu_id;
            }
            $this->_menuList = new Collection();
            self::buildMenu(0, $menuData);
        }
    }

    function buildMenu($parentId, $menuData)
    {
        if (isset($menuData['parents'][$parentId]))
        {
            foreach ($menuData['parents'][$parentId] as $itemId)
            {
                $item = $menuData['items'][$itemId];
                $item->level = 1;
                if ($parentId == 0)
                    $item->level = 0;
                else
                    $item->level = $menuData['items'][$parentId]->level + 1;
                $this->_menuList->push($item);

                // find childitems recursively
                $more = self::buildMenu($itemId, $menuData);
                if (!empty($more))
                    $this->_menuList->push($more);
            }
        }
    }

    function stripUnicode($str){
        if(!$str) return false;
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        );
        foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
        return $str;
    }
}
