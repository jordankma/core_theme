<?php

namespace Vne\Theme\App\Http\Controllers;

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
        if($theme == 'theme1'){
            Session::forget('notifi_verify');
            if($request->has('message')){
              $message = $request->input('message');
              Session::put('notifi_verify',$message); 
            }
            $id_position_banner_trangchu = config('site.banner_trang_chu_id');
            if (Cache::has('list_banner')) {
              $list_banner = Cache::get('list_banner');
            } else {
              $list_banner = Banner::where('position',$id_position_banner_trangchu)->orderBy('priority', 'desc')->get();
              Cache::put('list_banner', $list_banner,1440);
            }
            $id_position_banner_ngang_trangchu_1 = config('site.banner_ngang_trang_chu_id_1');
            $id_position_banner_ngang_trangchu_2 = config('site.banner_ngang_trang_chu_id_2');
            $id_position_banner_ngang_trangchu_3 = config('site.banner_ngang_trang_chu_id_3');

            if (Cache::has('banner_ngang_trang_chu_1')) {
              $banner_ngang_trang_chu_1 = Cache::get('banner_ngang_trang_chu_1');
            } else {
              $banner_ngang_trang_chu_1 = Banner::where('position',$id_position_banner_ngang_trangchu_1)->first();
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
            

            $thongbaobtc = config('site.news_box.thongbaobtc');
            $list_thong_bao_btc = self::getNewsByBoxFromCache($thongbaobtc, $thongbaobtc,null,5);

            $tinnong = config('site.news_box.tinnong');
            $list_news_hot = self::getNewsByBoxFromCache($tinnong, $tinnong , null, 5);
            
            $sukien = config('site.news_box.sukien');
            $list_news_event = self::getNewsByBoxFromCache($sukien, $sukien, null, 4);
            
            $honoivechungtoi = config('site.news_box.honoivechungtoi');
            $list_news_honoivechungtoi = self::getNewsByBoxFromCache($honoivechungtoi, $honoivechungtoi, null, 4);

            $hanhtrinhgiaothonghocduong = config('site.news_box.hanhtrinhgiaothonghocduong');
            $list_news_hanh_trinh_truong = self::getNewsByBoxFromCache($hanhtrinhgiaothonghocduong.'_1', $hanhtrinhgiaothonghocduong, 4, 4);
            $list_news_hanh_trinh_tinh = self::getNewsByBoxFromCache($hanhtrinhgiaothonghocduong.'_2', $hanhtrinhgiaothonghocduong, 5, 4);
            $list_news_hanh_trinh_toanquoc = self::getNewsByBoxFromCache($hanhtrinhgiaothonghocduong.'_3', $hanhtrinhgiaothonghocduong, 6, 4);
            $list_news_hanh_trinh_khac = self::getNewsByBoxFromCache($hanhtrinhgiaothonghocduong.'_4' , $hanhtrinhgiaothonghocduong,7,4);
            
            $hinhanhvideo = config('site.news_box.hinhanhvideo');
            $list_news_anh_video_1 = self::getNewsByBoxFromCache($hinhanhvideo.'_1', $hinhanhvideo, 8, 4);
            $list_news_anh_video_2 = self::getNewsByBoxFromCache($hinhanhvideo.'_2', $hinhanhvideo, 9, 4);
            
            if (Cache::has('list_time_line')) {
              $list_time_line = Cache::get('list_time_line');
            } else {
              $list_time_line = Timeline::all();
              Cache::put('list_time_line', $list_time_line,1440);
            }
            // dd($list_time_line);
            $id_don_vi_dong_hanh = config('site.don_vi_dong_hanh_id');
            $list_don_vi_dong_hanh = Companionunit::where('comtype',$id_don_vi_dong_hanh)->get();

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
            // dd($list_top_thi_sinh_da_thi);
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
            $minutes_countdown = self::getMinuteCountDown();
            // dd($minutes_countdown);
            $data = [
              'list_banner' => $list_banner,
              'list_thong_bao_btc' => $list_thong_bao_btc,
              'list_news_hot' => $list_news_hot,
              'list_news_event' => $list_news_event,
              'list_news_hanh_trinh_truong' => $list_news_hanh_trinh_truong,
              'list_news_hanh_trinh_tinh' => $list_news_hanh_trinh_tinh,
              'list_news_hanh_trinh_toanquoc' => $list_news_hanh_trinh_toanquoc,
              'list_news_hanh_trinh_khac' => $list_news_hanh_trinh_khac,
              'list_news_anh_video_1' => $list_news_anh_video_1,
              'list_news_anh_video_2' => $list_news_anh_video_2,
              'list_time_line' => $list_time_line,
              'list_top_thi_sinh_dang_ky' => $list_top_thi_sinh_dang_ky,
              'list_top_thi_sinh_da_thi' => $list_top_thi_sinh_da_thi,
              'list_thi_sinh_dan_dau_tuan' => $list_thi_sinh_dan_dau_tuan,
              'list_thi_sinh_moi' => $list_thi_sinh_moi,
              'list_don_vi_dong_hanh' => $list_don_vi_dong_hanh,
              'list_news_honoivechungtoi' => $list_news_honoivechungtoi,
              'count_thi_sinh_dang_ky' => $count_thi_sinh_dang_ky,
              'count_thi_sinh_thi' => $count_thi_sinh_thi,
              'minutes_countdown' => $minutes_countdown,
              'banner_ngang_trang_chu_1' => $banner_ngang_trang_chu_1,
              'banner_ngang_trang_chu_2' => $banner_ngang_trang_chu_2,
              'banner_ngang_trang_chu_3' => $banner_ngang_trang_chu_3,
              'type_page' => 'index'
            ];
            return view('VNE-THEME::modules.index.index',$data); 
        }
        elseif($theme == 'theme2'){
            $id_position_banner_trangchu = config('site.banner_trang_chu_id');
            $list_banner = Banner::where('position',$id_position_banner_trangchu)->get();

            $thongbaohoidongdoi = config('site.news_box.thongbaohoidongdoi');
            $list_news_thong_bao_hoi_dong_doi = $this->news->getNewsByBox($thongbaohoidongdoi,null,5);

            $renluyendoivien = config('site.news_box.renluyendoivien');
            $list_news_ren_luyen_doi_vien = $this->news->getNewsByBox($renluyendoivien,null,5);

            $sotayrenluyen = config('site.news_box.sotayrenluyen');
            $list_news_so_tay_ren_luyen = $this->news->getNewsByBox($sotayrenluyen,null,5);
            $hinhanhvideo = config('site.news_box.hinhanhvideo');
            $list_news_hinh_anh_video = $this->news->getNewsByBox($hinhanhvideo,null,5);


            $data = [
                'list_banner' => $list_banner,    
                'list_news_thong_bao_hoi_dong_doi' => $list_news_thong_bao_hoi_dong_doi,    
                'list_news_ren_luyen_doi_vien' => $list_news_ren_luyen_doi_vien,    
                'list_news_so_tay_ren_luyen' => $list_news_so_tay_ren_luyen,    
                'list_news_hinh_anh_video' => $list_news_hinh_anh_video, 
            ];
            return view('VNE-THEME::modules.index.index',$data);    
        }
    }

    public function getMinuteCountDown(){
      $minutes_countdown = 0;
      
      $date_now = new Datetime();
      $date_now_string = $date_now->format('Y-m-d H:i:s');
      $time_line = Timeline::where('starttime','>',$date_now_string)->first();
      if($time_line){
        $starttime = $time_line->starttime; 
        $minutes_countdown_timestamp = strtotime($starttime) - strtotime($date_now_string);
        $minutes_countdown = round($minutes_countdown_timestamp/60)*60 - 60*60*24*4;
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

    
}
