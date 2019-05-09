<?php

namespace Vne\Hocvalamtheobac\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

use Vne\News\App\Models\News;
use Vne\News\App\Repositories\NewsRepository;
use GuzzleHttp\Client;
use Vne\Hocvalamtheobac\App\ApiHash;

class NewsController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    private $rank_board;
    function setJsonRankBoard(){
        try {
            $this->rank_board = file_get_contents($this->url .'/api/contest/get/rank_board');
        } catch (\Throwable $th) {
            // throw $th;
        }  
    }

    public function __construct( NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $url = $this->url;
        Session::put('url.intended', URL::full());
        $this->setJsonRankBoard();
        $list_top_thi_sinh_dang_ky = $list_top_thi_sinh_da_thi = $list_thi_sinh_dan_dau_tuan = $list_thi_sinh_moi = array();
        try {
            $list_top = json_decode(file_get_contents($url . '/api/contest/get/rank_board?limit=3'));
            $list_top_thi_sinh_dang_ky = $list_top->data[0];
            $list_top_thi_sinh_da_thi = $list_top->data[1];
            $list_thi_sinh_dan_dau_tuan = $list_top->data[2];
        } catch (\Throwable $th) {
          //throw $th;
        }
        $count_thi_sinh_thi = $count_thi_sinh_dang_ky = 0;
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
        $share = [
            'list_top_thi_sinh_dang_ky' => $list_top_thi_sinh_dang_ky,
            'list_top_thi_sinh_da_thi' => $list_top_thi_sinh_da_thi,
            'list_thi_sinh_dan_dau_tuan' => $list_thi_sinh_dan_dau_tuan,
            'count_thi_sinh_thi' => $count_thi_sinh_thi,
            'count_thi_sinh_dang_ky' => $count_thi_sinh_dang_ky
        ];
        view()->share($share);
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
        return view('VNE-HOCVALAMTHEOBAC::modules.news.list',$data);
    }

    public function listNewsByBox(Request $request, $alias = null){
        $list_news = $this->news->getNewsByBox($alias,null,10); 
        $data = [
            'list_news' => $list_news     
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.news.list',$data);
    }


    public function detailNews($alias){
        $news = News::where('title_alias',$alias)->first();  
        $data = [
            'news' => $news     
        ];
        return view('VNE-HOCVALAMTHEOBAC::modules.news.details',$data);
    }
}
