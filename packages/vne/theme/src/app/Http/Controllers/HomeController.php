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

    public function listNews(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
    }

    public function detailNews(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
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

    public function showRegisterMember(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
    }

    public function updateRegisterMember(){
    	$list_banner = array();
    	$data = [
    		'list_banner' => $list_banner,
    		
    	];
        return view('VNE-THEME::modules.index.index');
    }
}
