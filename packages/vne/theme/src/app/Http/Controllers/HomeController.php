<?php

namespace Vne\Theme\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

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

    public function index(){
        $theme = config('site.theme');
        if($theme == 'theme1'){
            $id_position_banner_trangchu = config('site.banner_trang_chu_id');
            $list_banner = Banner::where('position',$id_position_banner_trangchu)->get();

            $thongbaobtc = config('site.news_box.thongbaobtc');
            $list_thong_bao_btc = $this->news->getNewsByBox($thongbaobtc,null,5);

            $tinnong = config('site.news_box.tinnong');
            $list_news_hot = $this->news->getNewsByBox($tinnong,null,5);
            
            $sukien = config('site.news_box.sukien');
            $list_news_event = $this->news->getNewsByBox($sukien,null,4);
            
            $honoivechungtoi = config('site.news_box.honoivechungtoi');
            $list_news_honoivechungtoi = $this->news->getNewsByBox($honoivechungtoi,null,4);

            $hanhtrinhgiaothonghocduong = config('site.news_box.hanhtrinhgiaothonghocduong');
            $list_news_hanh_trinh_truong = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,4,4);
            $list_news_hanh_trinh_tinh = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,5,4);
            $list_news_hanh_trinh_toanquoc = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,6,4);
            $list_news_hanh_trinh_khac = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,7,4);
            
            $hinhanhvideo = config('site.news_box.hinhanhvideo');
            $list_news_anh_video_1 = $this->news->getNewsByBox($hinhanhvideo,8,4);
            $list_news_anh_video_2 = $this->news->getNewsByBox($hinhanhvideo,9,4);

            $list_time_line = Timeline::all();

            $id_don_vi_dong_hanh = config('site.don_vi_dong_hanh_id');
            $list_don_vi_dong_hanh = Companionunit::where('comtype',$id_don_vi_dong_hanh)->get();

            $id_don_vi_tai_tro = config('site.don_vi_tai_tro_id');
            $list_don_vi_tai_tro = Companionunit::where('comtype',$id_don_vi_tai_tro)->get();

            $url = $this->url;
            $list_top_thi_sinh_dang_ky = $list_top_thi_sinh_da_thi = $list_thi_sinh_dan_dau_tuan = $list_thi_sinh_moi = array();
            $count_thi_sinh_dang_ky = 0;
            $count_thi_sinh_thi = 0;
            try {
                $list_top = json_decode(file_get_contents($url . '/api/contest/get/rank_board'));
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
              $count_thi_sinh_dang_ky = json_decode(file_get_contents($url . '/api/contest/get/search_candidate'))->total;
            } catch (\Throwable $th) {
              //throw $th;
            }
            try {
              $count_thi_sinh_thi = json_decode(file_get_contents($url . '/api/contest/search_contest_result'))->total;
            } catch (\Throwable $th) {
              //throw $th;
            }
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
              'list_don_vi_tai_tro' => $list_don_vi_tai_tro,
              'list_news_honoivechungtoi' => $list_news_honoivechungtoi,
              'count_thi_sinh_dang_ky' => $count_thi_sinh_dang_ky,
              'count_thi_sinh_thi' => $count_thi_sinh_thi
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

}
