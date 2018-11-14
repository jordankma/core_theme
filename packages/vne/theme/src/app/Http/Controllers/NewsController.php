<?php

namespace Vne\Theme\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;


use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Datetime,Session,URL,Schema;

use Vne\News\App\Models\News;
use Vne\News\App\Repositories\NewsRepository;
use GuzzleHttp\Client;
use Vne\Theme\App\ApiHash;

class NewsController extends Controller
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
        $url = config('app.url');
        Session::put('url.intended', URL::full());
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
}
