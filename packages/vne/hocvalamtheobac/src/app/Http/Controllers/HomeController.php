<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;
use Illuminate\Support\Facades\Cache;

use Vne\Banner\App\Models\Banner;
use Vne\Contact\App\Models\Contact;
use Vne\News\App\Models\News;
use Vne\Timeline\App\Models\Timeline;
use Vne\Companionunit\App\Models\Companionunit;
use Vne\News\App\Repositories\NewsRepository;

class HomeController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );  
    public function __construct( NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        Session::put('url.intended', URL::full());
    }

    public function index(Request $request){
        $theme = config('site.theme');
        $list_setting = $this->list_setting;
        $title_timeline = isset($list_setting['title_timeline']) ? $list_setting['title_timeline'] : '';
        $time_timeline = isset($list_setting['time_timeline']) ? $list_setting['time_timeline'] : 0;
        $open_fix = isset($list_setting['open_fix']) ? $list_setting['open_fix'] : '';
        if($open_fix=='on' && !$request->has('test')){
          return view('VNE-HOCVALAMTHEOBAC::modules.index.404'); 
        }
        
        //get banner
        $id_position_banner_ngang_trangchu_1 = config('site.banner.id_banner_ngang_trang_chu_1');
        $id_position_banner_ngang_trangchu_2 = config('site.banner.id_banner_ngang_trang_chu_2');
        $id_position_banner_ngang_trangchu_3 = config('site.banner.id_banner_ngang_trang_chu_3');
        if (Cache::has('banner_ngang_trang_chu_1')) {
          $banner_ngang_trang_chu_1 = Cache::get('banner_ngang_trang_chu_1');
        } else {
          $banner_ngang_trang_chu_1 = Banner::where('position',$id_position_banner_ngang_trangchu_1)->orderBy('priority', 'desc')->get();
          Cache::put('banner_ngang_trang_chu_1', $banner_ngang_trang_chu_1,1440);
        }
        if (Cache::has('banner_ngang_trang_chu_2')) {
          $banner_ngang_trang_chu_2 = Cache::get('banner_ngang_trang_chu_2');
        } else {
          $banner_ngang_trang_chu_2 = Banner::where('position',$id_position_banner_ngang_trangchu_2)->first();
          Cache::put('banner_ngang_trang_chu_2', $banner_ngang_trang_chu_2,1440);
        }
        if (Cache::has('banner_ngang_trang_chu_3')) {
          $banner_ngang_trang_chu_3 = Cache::get('banner_ngang_trang_chu_3');
        } else {
          $banner_ngang_trang_chu_3 = Banner::where('position',$id_position_banner_ngang_trangchu_3)->first();
          Cache::put('banner_ngang_trang_chu_3', $banner_ngang_trang_chu_3,1440);
        }
        //end get banner
        //get logo group
        $id_position_logo_ban_to_chuc_cuoc_thi = config('site.comunit.id_logo_ban_to_chuc_cuoc_thi');
        $id_position_logo_don_vi_dong_hanh = config('site.comunit.id_logo_don_vi_dong_hanh');
        $list_logo_ban_to_chuc_cuoc_thi = Companionunit::where('comtype',$id_position_logo_ban_to_chuc_cuoc_thi)->take(4)->get();
        $list_logo_don_vi_dong_hanh = Companionunit::where('comtype',$id_position_logo_don_vi_dong_hanh)->take(2)->get();
        //end get logo group
        //get tin tuc
        $thongbaobtc = config('site.news_box.thongbaobtc');
        $list_thong_bao_btc = self::getNewsByBoxFromCache($thongbaobtc, $thongbaobtc,null,5);

        $tintuc = config('site.news_box.tintuc');
        $list_tintuc = self::getNewsByBoxFromCache($tintuc, $tintuc,null,4);

        $videonoibat = config('site.news_box.videonoibat');
        $list_videonoibat = self::getNewsByBoxFromCache($videonoibat, $videonoibat,null,5);
        //end get tin tuc
        //get bang xep hang top
        $url = $this->url;
        $list_top_thi_sinh_dang_ky = $list_top_thi_sinh_da_thi = $list_thi_sinh_dan_dau_tuan = $list_thi_sinh_moi = array();
        $count_thi_sinh_dang_ky = 0;
        $count_thi_sinh_thi = 0;
        try {
            $list_top = json_decode(file_get_contents($url . '/api/contest/get/rank_board?limit=3'));
            $list_top_thi_sinh_dang_ky = $list_top->data[0];
            $list_top_thi_sinh_da_thi = $list_top->data[1];
            $list_thi_sinh_dan_dau_tuan = $list_top->data[2];
        } catch (\Throwable $th) {
          //throw $th;
        }
        // dd($list_thi_sinh_dan_dau_tuan);
        try {
          $list_thi_sinh_moi = json_decode(file_get_contents($url . '/api/contest/get/recent_reg'));
        } catch (\Throwable $th) {
          //throw $th;
        }
        try {
          if (Cache::has('count_thi_sinh_dang_ky')) {
            $count_thi_sinh_dang_ky = Cache::get('count_thi_sinh_dang_ky');
          } else {
            $count_thi_sinh_dang_ky = file_get_contents($url . '/api/contest/get/total?type=register');
            Cache::put('count_thi_sinh_dang_ky', $count_thi_sinh_dang_ky,10);
          }
          // $count_thi_sinh_dang_ky = json_decode(file_get_contents($url . '/api/contest/get/search_candidate'))->total;
        } catch (\Throwable $th) {
          //throw $th;
        }
        try {
          if (Cache::has('count_thi_sinh_thi')) {
            $count_thi_sinh_thi = Cache::get('count_thi_sinh_thi');
          } else {
            $count_thi_sinh_thi = file_get_contents($url . '/api/contest/get/total?type=candidate');
            Cache::put('count_thi_sinh_thi', $count_thi_sinh_thi,10);
          }
          // $count_thi_sinh_thi = json_decode(file_get_contents($url . '/api/contest/get/search_contest_result'))->total;
        } catch (\Throwable $th) {
          //throw $th;
        }
        //end get bang xep hang top
        $data = [
          'banner_ngang_trang_chu_1' => $banner_ngang_trang_chu_1,
          'banner_ngang_trang_chu_2' => $banner_ngang_trang_chu_2,
          'banner_ngang_trang_chu_3' => $banner_ngang_trang_chu_3,
          'list_thong_bao_btc' => $list_thong_bao_btc,
          'list_tintuc' => $list_tintuc,
          'list_videonoibat' => $list_videonoibat,
          'last_page_tin_tuc' => $list_tintuc->lastPage(),
          'list_top_thi_sinh_dang_ky' => $list_top_thi_sinh_dang_ky,
          'list_top_thi_sinh_da_thi' => $list_top_thi_sinh_da_thi,
          'list_thi_sinh_dan_dau_tuan' => $list_thi_sinh_dan_dau_tuan,
          'list_thi_sinh_moi' => $list_thi_sinh_moi,
          'list_logo_ban_to_chuc_cuoc_thi' => $list_logo_ban_to_chuc_cuoc_thi,
          'list_logo_don_vi_dong_hanh' => $list_logo_don_vi_dong_hanh,
          'count_thi_sinh_dang_ky' => $count_thi_sinh_dang_ky
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.index.index',$data);    
    }
    
    public function getMinuteCountDown($time){
      $minutes_countdown = 0;
      
      $date_now = new Datetime();
      $date_now_string = $date_now->format('Y-m-d H:i:s');
      $time_line = Timeline::where('starttime','>',$date_now_string)->first();
      if($time_line){
        $starttime = $time_line->starttime; 
        $minutes_countdown_timestamp = strtotime($starttime) - strtotime($date_now_string);
        $minutes_countdown = round($minutes_countdown_timestamp/60)*60 + 60*60*$time;
      }
      return $minutes_countdown; 
    }

    function getNewsByBoxFromCache($key_cache, $alias, $news_cat_id, $limit){
      if (Cache::has($key_cache)) {
        $data = Cache::get($key_cache);
      } else {
        $data = $this->news->getNewsByBox($alias, $news_cat_id, $limit);
        Cache::put($key_cache, $data,1440);
      }
      return $data;  
    }

    public function getNewByBox(Request $request,$alias){
      $list_news = $this->news->getNewsByBox($alias,null,4);
      $list_news_json = array();
      if(!empty($list_news)){
          foreach ($list_news as $key => $news) {
              $list_news_json[] = [
                  'news_id' => $news->news_id,
                  'title_alias' => $news->title_alias,
                  'title' => $news->title,
                  'image' => $news->image,
                  'created_at' => date_format($news->created_at,"Y/m/d"),
                  'desc' => $news->desc,
                  'create_by' => $news->create_by
              ];
          }
      }
      return json_encode($list_news_json);
    }  
}
