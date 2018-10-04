<?php

namespace Vne\Theme\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

use Vne\Banner\App\Models\Banner;
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
        $list_thong_bao_btc = $this->news->getNewsByBox($thongbaobtc,5);

        $tinnong = config('site.news_box.tinnong');
        $list_news_hot = $this->news->getNewsByBox($tinnong,5);
        
        $sukien = config('site.news_box.sukien');
        $list_news_event = $this->news->getNewsByBox($sukien,4);


        $data = [
            'list_banner' => $list_banner,
            'list_thong_bao_btc' => $list_thong_bao_btc,
            'list_news_hot' => $list_news_hot,
            'list_news_event' => $list_news_event,
            
        ];
        return view('VNE-THEME::modules.index.index',$data);
    }

    public function showContact(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
    }

    public function updateContact(){
        $list_banner = array();
        $data = [
            'list_banner' => $list_banner,
            
        ];
        return view('VNE-THEME::modules.index.index');
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
