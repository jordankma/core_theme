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
use Vne\Member\App\Models\Member;
use Vne\Timeline\App\Models\Timeline;
use Vne\Companionunit\App\Models\Companionunit;
use Vne\News\App\Repositories\NewsRepository;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    protected $secret_key = '8bgCi@gsLbtGhO)1';
    protected $secret_iv = ')FQKRL57zFYdtn^!';
    protected $url_api_prefix;
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $register_form = '{
        "data": {
          "load_default": [
            {
                "id" : 1,
                "title": "Tên đăng nhập",
                "hint_text": "Tên đăng nhập",
                "class" : "",
                "id" : "",
                "type": "text",
                "params": "user_name",
                "type_view": 0,
                "is_require": true,
                "is_search": true
            },
            {
                "id": 2,
                "title": "Đề tài",
                "params": "gioitinh",
                "hint_text": "Chọn giới tính",
                "class" : "",
                "id" : "",
                "type_view": 2,
                "is_require": true,
                "is_search": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Nam"
                  },
                  {
                    "id": 2,
                    "title": "Nữ"
                  }
                ]
              },
              {
                "id": 4,
                "title": "Chọn công việc bạn yêu thich",
                "params": "chonABC",
                "hint_text": "Chọn giới tính",
                "class" : "",
                "id" : "",
                "type_view": 3,
                "is_require": true,
                "is_search": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Thích đi học"
                  },
                  {
                    "id": 2,
                    "title": "Thích nghe nhạc"
                  },
                  {
                    "id": 2,
                    "title": "Thích ăn kem"
                  },
                  {
                    "id": 2,
                    "title": "Thích đá bóng"
                  },
                  {
                    "id": 2,
                    "title": "Thích ngủ"
                  }
                ]
              }
            ]
          ,
            "target": [
              {
            "id": 1,
            "title": "Hoc sinh",
          
            "form_data": [
              {
                "id": 1,
                "title": "Tên đăng nhập",
                "hint_text": "Tên đăng nhập",
                "class" : "",
                "id" : "",
                "type": "text",
                "params": "user_name",
                "type_view": 0,
                "is_require": true,
                "is_search": true
              },
              {
                "id": 2,
                "title": "Họ và tên",
                "params": "name",
                "type": "text",
                "hint_text": "Họ tên",
                "class" : "",
                "id" : "",
                "type_view": 0,
                "is_require": true,
                "is_search": true
              
              },
              {
                "id": 3,
                "title": "Tỉnh/Thành phố",
                "params": "city",
                "hint_text": "Chọn tỉnh/thành",
                "class" : "",
                "id" : "city",
                "type_view": 1,
                "type": "data",
                "api" : "http://theme.local.vn/get/district",
                "is_require": true,
                "is_search": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Hà Nội"
                  },
                  {
                    "id": 2,
                    "title": "Hưng Yên"
                  },
                  {
                    "id": 3,
                    "title": "Hải Phòng"
                  }
                ]
              },
              {
                 "id": 4,
                "title": "Quận/ huyện",
                "params": "district",
                "hint_text": "Chọn Quận/huyện",
                "class" : "",
                "id" : "district",
                "type_view": 1,
                "type": "api",
                "api": "http://theme.local.vn/get/school",
                "is_require": true,
                "is_search": true,
                "data_view": [
                ]
              },
              {
                 "id": 4,
                "title": "Trường",
                "params": "school",
                "hint_text": "Chọn Quận/huyện",
                "class" : "",
                "id" : "school",
                "type_view": 1,
                "type": "api",
                "api": "",
                "is_require": true,
                "is_search": true,
                "data_view": [
                ]
              },
              {
                "id": 4,
                "title": "Tên bài viết",
                "params": "note",
                "hint_text": "Tên bài viết",
                "class" : "",
                "id" : "",
                "type" : "text",
                "type_view": 0,
                "is_require": true,
                "is_search": true
              },
              {
                "id": 3,
                "title": "Đề tài",
                "params": "topic",
                "hint_text": "Chọn đề tài",
                "class" : "",
                "id" : "",
                "api" : "",
                "type_view": 1,
                "is_require": true,
                "is_search": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Đề tài 1"
                  },
                  {
                    "id": 2,
                    "title": "Đề tài 2"
                  },
                  {
                    "id": 3,
                    "title": "Đề tài 3"
                  }
                ]
              },
              {
                "id": 3,
                "title": "Đề tài",
                "params": "gioitinh",
                "hint_text": "Chọn giới tính",
                "class" : "",
                "id" : "",
                "type_view": 2,
                "is_require": true,
                "is_search": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Nam"
                  },
                  {
                    "id": 2,
                    "title": "Nữ"
                  }
                ]
              },
              {
                "id": 3,
                "title": "Chọn công việc bạn yêu thich",
                "params": "chonABC",
                "hint_text": "Chọn giới tính",
                "class" : "",
                "id" : "",
                "type_view": 3,
                "is_require": true,
                "is_search": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Thích đi học"
                  },
                  {
                    "id": 2,
                    "title": "Thích nghe nhạc"
                  },
                  {
                    "id": 2,
                    "title": "Thích ăn kem"
                  },
                  {
                    "id": 2,
                    "title": "Thích đá bóng"
                  },
                  {
                    "id": 2,
                    "title": "Thích ngủ"
                  }
                ]
              }
            ]
          },
              {
            "id": 2,
            "title": "Sinh vien di lam",
            "form_data": [
              {
                "id": 1,
                "title": "Tên đăng nhập",
                "hint_text": "Tên đăng nhập",
                "class" : "",
                "id" : "",
                "params": "user_name",
                "type" : "text",
                "type_view": 0,
                "is_require": true
              },
              {
                "id": 2,
                "title": "Họ và tên",
                "params": "name",
                "hint_text": "Họ tên",
                "class" : "",
                "id" : "",
                "type" : "text",
                "type_view": 0,
                "is_require": true
              },
              {
                "id": 3,
                "title": "Tỉnh/Thành phố",
                "params": "city",
                "hint_text": "Chọn tỉnh/thành",
                "class" : "",
                "id" : "city",
                "type_view": 1,
                "api" : "http://theme.local.vn/get/district",
                "is_require": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Hà Nội"
                  },
                  {
                    "id": 2,
                    "title": "Hưng Yên"
                  },
                  {
                    "id": 3,
                    "title": "Hải Phòng"
                  }
                ]
              },
              {
                "id": 4,
                "title": "Tên bài viết",
                "params": "note",
                "hint_text": "Tên bài viết",
                "class" : "",
                "id" : "",
                "type" : "text",
                "type_view": 0,
                "is_require": true
              },
              {
                "id": 3,
                "title": "Đề tài",
                "params": "topic",
                "hint_text": "Chọn đề tài",
                "class" : "",
                "id" : "",
                "api" : "",
                "type_view": 1,
                "is_require": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Đề tài 1"
                  },
                  {
                    "id": 2,
                    "title": "Đề tài 2"
                  },
                  {
                    "id": 3,
                    "title": "Đề tài 3"
                  }
                ]
              },
              {
                "id": 3,
                "title": "Đề tài",
                "params": "gioitinh",
                "hint_text": "Chọn giới tính",
                "class" : "",
                "id" : "",
                "type_view": 2,
                "is_require": true,
                "data_view": [
                  {
                    "id": 1,
                    "title": "Nam"
                  },
                  {
                    "id": 2,
                    "title": "Nữ"
                  }
                ]
              }
            ]
          }
              ]
         
        },
        "config": {
          "0": "input",
          "1": "selectbox",
          "2": "radio",
          "3": "checkbox"
        },
        "success": true,
        "message": "ok!"
      }';
    function setUrlApiPrefix(){
      $this->url_api_prefix = config('app.url').config('site.api_prefix');   
    }
    public function __construct( NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $url = config('app.url');
        Session::put('url.intended', URL::full());
        $this->setUrlApiPrefix();
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
            $url = config('app.url');
            $url = 'http://gthd.vnedutech.vn/';
            $list_top_thi_sinh_dang_ky_tinh = file_get_contents($url . 'api/contest/get/top/register?top_type=province&top=3&page=1&table_id=');
            $list_top_thi_sinh_dang_ky_truong = file_get_contents($url . 'api/contest/get/top/register?top_type=school&top=3&page=1&table_id=');

            $list_top_thi_sinh_da_thi_tinh = file_get_contents($url . 'api/contest/get/top/candidate?top_type=province&top=3&page=1&table_id=&round_id=&topic_id=');
            
            $list_top_thi_sinh_da_thi_truong = file_get_contents($url . 'api/contest/get/top/candidate?top_type=school&top=3&page=1&table_id=&round_id=&topic_id=');

            $list_thi_sinh_dan_dau_tuan =  file_get_contents($url . 'api/contest/get/top/result?top_type=province&top=4&page=1&table_id=2&round_id=4&topic_id=5'); 

            $list_thi_sinh_moi = '[
                {
                    "name" : "lê văn A",
                    "address" : "Lớp 8 - THCS Vinh Tân - Nghệ An"
                },
                {
                    "name" : "lê văn B",
                    "address" : "Lớp 8 - THCS Vinh Tân - Nghệ An"
                },
                {
                    "name" : "lê văn C",
                    "address" : "Lớp 8 - THCS Vinh Tân - Nghệ An"
                },
                {
                    "name" : "lê văn C",
                    "address" : "Lớp 8 - THCS Vinh Tân - Nghệ An"
                }
            ]';
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
              'list_top_thi_sinh_dang_ky_tinh' => json_decode($list_top_thi_sinh_dang_ky_tinh),
              'list_top_thi_sinh_dang_ky_truong' => json_decode($list_top_thi_sinh_dang_ky_truong),
              'list_top_thi_sinh_da_thi_tinh' => json_decode($list_top_thi_sinh_da_thi_tinh),
              'list_top_thi_sinh_da_thi_truong' => json_decode($list_top_thi_sinh_da_thi_truong),
              'list_thi_sinh_dan_dau_tuan' => json_decode($list_thi_sinh_dan_dau_tuan),
              'list_thi_sinh_moi' => json_decode($list_thi_sinh_moi),
              'list_don_vi_dong_hanh' => $list_don_vi_dong_hanh,
              'list_don_vi_tai_tro' => $list_don_vi_tai_tro,
              'list_news_honoivechungtoi' => $list_news_honoivechungtoi
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

    public function listMember(){
      return view('VNE-THEME::modules.search.search_member');
    }

    public function listResult(){
      return view('VNE-THEME::modules.search.search_result');
    }

    public function getTopResult(){
      $title = "Top thí sinh thi";
      $url = config('app.url');
      $url = 'http://gthd.vnedutech.vn/';
      $list_top_thi_sinh_da_thi_tinh = file_get_contents($url . 'api/contest/get/top/candidate?top_type=province&top=all&page=1&table_id=&round_id=&topic_id=');
            
      $list_top_thi_sinh_da_thi_truong = file_get_contents($url . 'api/contest/get/top/candidate?top_type=school&top=100&page=1&table_id=&round_id=&topic_id=');
      $data = [
        'title' => $title,
        'list_top_thi_sinh_da_thi_tinh' => json_decode($list_top_thi_sinh_da_thi_tinh),
        'list_top_thi_sinh_da_thi_truong' => json_decode($list_top_thi_sinh_da_thi_truong)
      ];
      return view('VNE-THEME::modules.search.rating',$data);
    }
    public function getTopRegister(){
      $title = "Top thí sinh đăng ký";
      $url = config('app.url');
      $url = 'http://gthd.vnedutech.vn/';
      $list_top_thi_sinh_dang_ky_tinh = file_get_contents($url . 'api/contest/get/top/register?top_type=province&top=all&page=1&table_id=');
      $list_top_thi_sinh_dang_ky_truong = file_get_contents($url . 'api/contest/get/top/register?top_type=school&top=100&page=1&table_id=');
      $data = [
        'title' => $title,
        'list_top_thi_sinh_dang_ky_tinh' => json_decode($list_top_thi_sinh_dang_ky_tinh),
        'list_top_thi_sinh_dang_ky_truong' => json_decode($list_top_thi_sinh_dang_ky_truong)
      ];
      return view('VNE-THEME::modules.search.rating_register',$data);
    }
    public function showContact(){
      return view('VNE-THEME::modules.contact.contact');
    }

    public function saveContact(Request $request){
        $contact = new Contact();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email_contact');
        $contact->content = $request->input('content');
        $contact->created_at = new Datetime();
        if($contact->save()) {
            return view('VNE-THEME::modules.contact.contact')->with('thongbao','Gửi liên hệ thành công');
        }

    }

    public function getTryExam(Request $request){
      $url_source_try = config('site.url_source_try');
      $game_token = $request->input('token');
      $linkresult = 'http://timhieubiendao.daknong.vn';
      $linkaudio = $url_source_try.'/res/sound/';
      $linkhome = 'http://timhieubiendao.daknong.vn';
      $ip_port = 'http://123.30.174.148:4555/';
      $linkimg = 'http://quiz2.vnedutech.vn';
      $linkquest = 'http://quiz2.vnedutech.vn/json/contest/5/9_file.json?v=1539684969';
      $test = 'false';
      $m_level = '3';
      $type = '2';
      $url = $url_source_try . '/index.php?game_token=' . $game_token . '&linkresult=' . $linkresult . '&linkaudio=' . $linkaudio . '&linkhome=' . $linkhome . '&ip_port=' . $ip_port . '&linkimg=' . $linkimg . '&linkquest=' . $linkquest . '&test=' . $test . '&m_level=' . $m_level . '&type=' . $type;
      $data = [
        'url' => $url
      ];
      return view('VNE-THEME::modules.contest.index',$data);
    }

    public function getRealExam(Request $request){
      $url_source_real = config('site.url_source_real');
      $game_token = $request->input('token');
      $linkresult = 'http://timhieubiendao.daknong.vn';
      $linkaudio = $url_source_real.'/res/sound/';
      $linkhome = 'http://timhieubiendao.daknong.vn';
      $ip_port = 'http://java.cuocthi.vnedutech.vn/';
      $linkimg = 'http://quiz2.vnedutech.vn';
      $linkquest = 'http://quiz2.vnedutech.vn/json/contest/5/9_file.json?v=1539684969';
      $test = 'false';
      $m_level = '3';
      $type = '2';
      $url = $url_source_real . '/index.php?game_token=' . $game_token . '&linkresult=' . $linkresult . '&linkaudio=' . $linkaudio . '&linkhome=' . $linkhome . '&ip_port=' . $ip_port . '&linkimg=' . $linkimg . '&linkquest=' . $linkquest . '&test=' . $test . '&m_level=' . $m_level . '&type=' . $type;
      $data = [
        'url' => $url
      ];
      return view('VNE-THEME::modules.contest.index',$data);
    }

    public function listNews(Request $request, $alias = null){
        if($alias==null){
            $list_news = News::orderBy('news_id', 'desc')->paginate(10);  
        } else {
            $list_news = $this->news->getNewsByCate($alias,10);    
        }
        $data = [
            'list_news' => $list_news     
        ];
        return view('VNE-THEME::modules.news.list',$data);
    }

    public function listNewsByBox(Request $request, $alias = null){
        $list_news = $this->news->getNewsByBox($alias,null,10); 
        $data = [
            'list_news' => $list_news     
        ];
        return view('VNE-THEME::modules.news.list',$data);
    }


    public function detailNews($alias){
        $news = News::where('title_alias',$alias)->first();  
        $data = [
            'news' => $news     
        ];
        return view('VNE-THEME::modules.news.details',$data);
    }

    public function listExam(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
    }

    public function detailExam(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
    }

    public function scheduleExam(){
      $link_get_schedule = $this->api_prefix.'/vne/gettimeline';
      $schedule = file_get_contents($link_get_schedule);
      $schedule = json_decode($schedule);
      $data = [
          'schedule' => $schedule->data
      ];
      return view('VNE-THEME::modules.exam.schedule',$data);
    }

    public function showRegisterMember(Request $request){
        $register_form = $this->register_form;
        $register_form_array = json_decode($register_form,true);
        $data = [
          'list_object' => $register_form_array['data']['target'],
          'config' => $register_form_array['config'],
          'form_data_default' => $register_form_array['data']['load_default']
        ];
        return view('VNE-THEME::modules.member.register',$data);
    }

    public function getFormRegister(Request $request){
      $validator = Validator::make($request->all(), [
            'object_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
          $object_id = $request->input('object_id');
          $register_form = $this->register_form;
          $register_form_array = json_decode($register_form,true);
          foreach ($register_form_array['data']['target'] as $key => $value ) {
            if($value['id'] == $object_id){
              $form_data = $value['form_data'];
              break; 
            }      
          }
          $str = '';
          if(count($form_data) > 0){
            $html = view('VNE-THEME::modules.member.input', compact('form_data'));
            $str = $html->render();
          }
          return response()->json(['str'=>$str]);
        } else {
          return $validator->messages();
        }        
    }

    public function updateRegisterMember(Request $request){
      $member = Member::where('member_id',$request->input('member_id'))->first();
      if(empty($member)){
        $member = new Member();
        $data_request = $request->all();
        if(!empty($data_request)){
          foreach ($data_request as $key => $value) {
            $member->addColumn('vne_member',$key);
            if(gettype($request->input($key))=='array'){
              $member->$key = json_encode($request->input($key));
            } else{
              $member->$key = $request->input($key); 
            }
          }
        }
        if($member->save()){
          $member->is_reg = '1';
          $member->update();
          $data = $member->getAttributes();
          $data = http_build_query($data);
          $data_encrypt = $this->my_simple_crypt($data);
          try {
              $url = config('app.url');
              $url = 'http://gthd.vnedutech.vn';
              $result = file_get_contents($url . '/admin/api/contest/candidate_register?data='. $data_encrypt);
              $result = json_decode($result);
              if($result->status == true){
                  $member->sync_mongo = '1';
                  $member->update();
                  return redirect()->route('index');
              }
              else{
                  return redirect()->route('frontend.member.register.show');
              }
          } catch (Exception $e) {
              
          }
          return redirect()->route('index');
        }
      } else{
        return redirect()->route('index');  
      }
    }

    public function getDistrict(Request $request){
        $list_district = array();
        try {
          $list_district = file_get_contents('http://cuocthi.vnedutech.vn/resource/dev/get/vne/getdistricts/'.$request->input('city_id'));
          $list_district = json_decode($list_district);
        } catch (Exception $e) {
          
        }
        $list_district_json = array();
        if(!empty($list_district->data)){
            foreach ($list_district->data as $key => $district) {
                $list_district_json[] = [
                    'district_id' => $district->_id,
                    'name' => $district->district
                ];
            }
        }
        return json_encode($list_district_json);      
    }

    public function getSchool(Request $request){
        $list_school = file_get_contents('http://cuocthi.vnedutech.vn/resource/dev/get/vne/getschools/'.$request->input('district_id'));
        $list_school = json_decode($list_school);
        $list_school_json = array();
        if(!empty($list_school->data)){
            foreach ($list_school->data as $key => $school) {
                $list_school_json[] = [
                    'school_id' => $school->_id,
                    'name' => $school->schoolname
                ];
            }
        }
        return json_encode($list_school_json);      
    }

    public function getClass(Request $request){
        $list_class = array();
        $list_class_json = array();
        if(!empty($list_class)){
            foreach ($list_class as $key => $class) {
                $list_class_json[] = [
                    'class_id' => $class->class_id,
                    'name' => $class->name
                ];
            }
        }
        return json_encode($list_class_json);      
    }

    function my_simple_crypt( $string, $action = 'e' ) {
        // you may change these values to your own
        $secret_key = $this->secret_key;
        $secret_iv = $this->secret_iv;
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = substr( hash( 'sha256', $secret_key ), 0 ,32);
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
        return $output;
    }
}
