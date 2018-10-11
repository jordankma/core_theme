<?php

namespace Vne\Theme\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime;

use Vne\Banner\App\Models\Banner;
use Vne\Contact\App\Models\Contact;
use Vne\News\App\Models\News;

use Vne\News\App\Repositories\NewsRepository;
use GuzzleHttp\Client;

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
    }

    public function index(){
        $theme = $this->theme;
        if($theme == 'theme1'){
            $id_position_banner_trangchu = config('site.banner_trang_chu_id');
            $list_banner = Banner::where('position',$id_position_banner_trangchu)->get();

            $thongbaobtc = config('site.news_box.thongbaobtc');
            $list_thong_bao_btc = $this->news->getNewsByBox($thongbaobtc,null,5);

            $tinnong = config('site.news_box.tinnong');
            $list_news_hot = $this->news->getNewsByBox($tinnong,null,5);
            
            $sukien = config('site.news_box.sukien');
            $list_news_event = $this->news->getNewsByBox($sukien,null,4);

            $hanhtrinhgiaothonghocduong = config('site.news_box.hanhtrinhgiaothonghocduong');
            $list_news_hanh_trinh_truong = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,4,4);
            $list_news_hanh_trinh_tinh = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,5,4);
            $list_news_hanh_trinh_toanquoc = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,6,4);
            $list_news_hanh_trinh_khac = $this->news->getNewsByBox($hanhtrinhgiaothonghocduong,7,4);
            
            $hinhanhvideo = config('site.news_box.hinhanhvideo');

            $list_news_anh_video_1 = $this->news->getNewsByBox($hinhanhvideo,8,4);
            $list_news_anh_video_2 = $this->news->getNewsByBox($hinhanhvideo,9,4);

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
                'list_news_anh_video_2' => $list_news_anh_video_2
                
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
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
    }

    public function showRegisterMember(Request $request){
        $register_form = '{
          "register_form": {
            "target_list": [
              {
                "target_id": 1,
                "target_name": "Học sinh Tiểu học"
              },
              {
                "target_id": 2,
                "target_name": "Học sinh THCS"
              },
               {
                "target_id": 3,
                "target_name": "Học sinh THPT"
              },
               {
                "target_id": 4,
                "target_name": "Giáo viên"
              }
            ],
            "target_data": [
              {
                "target_id": 1,
                "data": [
                  {
                    "province": {
                      "label": "Tỉnh/ TP",
                      "varible": "province",
                      "input_type": "select_data",
                      "value": "[1,2,3,4]",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getprovince?list=",
                      "is_require": true
                    },
                    "district": {
                      "label": "Quận/ huyện",
                      "varible": "district",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getdistricts/",
                      "is_require": true
                    },
                    "school": {
                      "label": "Trường",
                      "varible": "school",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getschools/",
                      "is_require": true
                    },
                    "gclass": {
                      "label": "Khối lớp",
                      "varible": "gclass",
                      "input_type": "select",
                      "value": {
                        "1": "Lớp 1",
                        "2": "Lớp 2",
                        "3": "Lớp 3",
                        "4": "Lớp 4",
                        "5": "Lớp 5",
                        "6": "Lớp 6",
                        "7": "Lớp 7",
                        "8": "Lớp 8",
                        "9": "Lớp 9",
                        "10": "Lớp 10",
                        "11": "Lớp 11",
                        "12": "Lớp 12"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "phone": {
                      "label": "Điện thoại",
                      "varible": "phone",
                      "input_type": "number",
                      "value": "",
                      "api": "",
                      "is_require": true
                    },
                    "gender": {
                      "label": "Giới tính",
                      "varible": "gender",
                      "input_type": "radio",
                      "value": {
                        "male": "Nam",
                        "female": "Nữ"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "email": {
                      "label": "Email",
                      "varible": "email",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    },
                    "facebook": {
                      "label": "Facebook",
                      "varible": "facebook",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    }
                  }
                ]
              },
              {
                "target_id": 2,
                "data": [
                  {
                    "province": {
                      "label": "Tỉnh/ TP",
                      "varible": "province",
                      "input_type": "select_data",
                      "value": "[1,2,3,4]",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getprovince?list=",
                      "is_require": true
                    },
                    "district": {
                      "label": "Quận/ huyện",
                      "varible": "district",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getdistricts/",
                      "is_require": true
                    },
                    "school": {
                      "label": "Trường",
                      "varible": "school",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getschools/",
                      "is_require": true
                    },
                    "gclass": {
                      "label": "Khối lớp",
                      "varible": "gclass",
                      "input_type": "select",
                      "value": {
                        "1": "Lớp 1",
                        "2": "Lớp 2",
                        "3": "Lớp 3",
                        "4": "Lớp 4",
                        "5": "Lớp 5",
                        "6": "Lớp 6",
                        "7": "Lớp 7",
                        "8": "Lớp 8",
                        "9": "Lớp 9",
                        "10": "Lớp 10",
                        "11": "Lớp 11",
                        "12": "Lớp 12"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "phone": {
                      "label": "Điện thoại",
                      "varible": "phone",
                      "input_type": "number",
                      "value": "",
                      "api": "",
                      "is_require": true
                    },
                    "gender": {
                      "label": "Giới tính",
                      "varible": "gender",
                      "input_type": "radio",
                      "value": {
                        "male": "Nam",
                        "female": "Nữ"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "email": {
                      "label": "Email",
                      "varible": "email",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    },
                    "facebook": {
                      "label": "Facebook",
                      "varible": "facebook",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    }
                  }
                ]
              },
              {
                "target_id": 3,
                "data": [
                  {
                    "province": {
                      "label": "Tỉnh/ TP",
                      "varible": "province",
                      "input_type": "select_data",
                      "value": "[1,2,3,4]",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getprovince?list=",
                      "is_require": true
                    },
                    "district": {
                      "label": "Quận/ huyện",
                      "varible": "district",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getdistricts/",
                      "is_require": true
                    },
                    "school": {
                      "label": "Trường",
                      "varible": "school",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getschools/",
                      "is_require": true
                    },
                    "gclass": {
                      "label": "Khối lớp",
                      "varible": "gclass",
                      "input_type": "select",
                      "value": {
                        "1": "Lớp 1",
                        "2": "Lớp 2",
                        "3": "Lớp 3",
                        "4": "Lớp 4",
                        "5": "Lớp 5",
                        "6": "Lớp 6",
                        "7": "Lớp 7",
                        "8": "Lớp 8",
                        "9": "Lớp 9",
                        "10": "Lớp 10",
                        "11": "Lớp 11",
                        "12": "Lớp 12"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "phone": {
                      "label": "Điện thoại",
                      "varible": "phone",
                      "input_type": "number",
                      "value": "",
                      "api": "",
                      "is_require": true
                    },
                    "gender": {
                      "label": "Giới tính",
                      "varible": "gender",
                      "input_type": "radio",
                      "value": {
                        "male": "Nam",
                        "female": "Nữ"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "email": {
                      "label": "Email",
                      "varible": "email",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    },
                    "facebook": {
                      "label": "Facebook",
                      "varible": "facebook",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    }
                  }
                ]
              },
              {
                "target_id": 4,
                "data": [
                  {
                    "province": {
                      "label": "Tỉnh/ TP",
                      "varible": "province",
                      "input_type": "select_data",
                      "value": [
                        1,
                        2,
                        3,
                        4
                      ],
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getprovince?list=",
                      "is_require": true
                    },
                    "district": {
                      "label": "Quận/ huyện",
                      "varible": "district",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getdistricts/",
                      "is_require": true
                    },
                    "school": {
                      "label": "Trường",
                      "varible": "school",
                      "input_type": "select_data",
                      "value": "",
                      "api": "http://cuocthi.vnedutech.vn/admin/vne/getschools/",
                      "is_require": true
                    },
                    "phone": {
                      "label": "Điện thoại",
                      "varible": "phone",
                      "input_type": "number",
                      "value": "",
                      "api": "",
                      "is_require": true
                    },
                    "cmnd": {
                      "label": "Số CMND",
                      "varible": "cmnd",
                      "input_type": "number",
                      "value": "",
                      "api": "",
                      "is_require": true
                    },
                    "gender": {
                      "label": "Giới tính",
                      "varible": "gender",
                      "input_type": "radio",
                      "value": {
                        "male": "Nam",
                        "female": "Nữ"
                      },
                      "api": "",
                      "is_require": true
                    },
                    "email": {
                      "label": "Email",
                      "varible": "email",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    },
                    "facebook": {
                      "label": "Facebook",
                      "varible": "facebook",
                      "input_type": "text",
                      "value": "[]",
                      "api": "",
                      "is_require": false
                    }
                  }
                ]
              }
            ]
          }
        }';
        $data_form = json_decode($register_form,true);

        $client = new Client();
        $res = $client->request('GET', 'http://cuocthi.vnedutech.vn/admin/vne/getprovince'); 
        $data_reponse = json_decode($res->getBody(),true);
        
        $data = [
          'list_target' => $data_form['register_form']['target_list'],
          'list_provine' => $data_reponse['data'],
          'data_form' => $data_form
        ];
        return view('VNE-THEME::modules.member.register',$data);
    }

    public function updateRegisterMember(){
    	$list_banner = array();

    	$data = [
    		'list_banner' => $list_banner,
    		
    	];
        return view('VNE-THEME::modules.index.index');
    }

    public function getDistrict(Request $request){
        $list_district = array();
        $list_district_json = array();
        if(!empty($list_district)){
            foreach ($list_district as $key => $district) {
                $list_district_json[] = [
                    'district_id' => $district->district_id,
                    'name' => $district->name
                ];
            }
        }
        return json_encode($list_district_json);      
    }

    public function getSchool(Request $request){
        $list_school = array();
        $list_school_json = array();
        if(!empty($list_school)){
            foreach ($list_school as $key => $school) {
                $list_school_json[] = [
                    'school_id' => $school->school_id,
                    'name' => $school->name
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
}
