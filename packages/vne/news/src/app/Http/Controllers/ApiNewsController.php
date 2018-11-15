<?php

namespace Vne\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Illuminate\Support\Collection;
use Vne\News\App\Http\Requests\NewsCatRequest;
use Vne\News\App\Http\Requests\NewsRequest;

use Vne\News\App\Repositories\NewsRepository;
use Vne\News\App\Repositories\NewsCatRepository;
use Vne\News\App\Repositories\NewsTagRepository;
use Vne\News\App\Repositories\NewsBoxRepository;
use Vne\News\App\Repositories\NewsHasTagRepository;
use Vne\News\App\Repositories\NewsHasCatRepository;

use Vne\News\App\Models\News;
use Vne\News\App\Models\NewsCat;
use Vne\News\App\Models\NewsTag;
use Vne\News\App\Models\NewsBox;
use Vne\News\App\Models\NewsHasTag;
use Vne\News\App\Models\NewsHasCat;
use Vne\News\App\Models\NewsHasBox;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ApiNewsController extends Controller
{	
	protected $_newsCatList;
	private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

	public function __construct(NewsRepository $newsRepository, NewsCatRepository $newsCatRepository,NewsTagRepository $newsTagRepository,NewsHasTagRepository $newsHasTagRepository,NewsHasCatRepository $newsHasCatRepository,NewsBoxRepository $newsBoxRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $this->news_cat = $newsCatRepository;
        $this->news_tag = $newsTagRepository;
        $this->news_has_tag = $newsHasTagRepository;
        $this->news_has_cat = $newsHasCatRepository;
        $this->news_box = $newsBoxRepository;
        $this->_user = Auth::user();
    }

    public function getListNewsApi(Request $request){
        $list_news = News::paginate(10);
        $data = array();
        if(!empty($list_news)){
            foreach ($list_news as $key => $value) {
                $data[] = [
                    'id' => $value->news_id,
                    'title' => base64_encode($value->title),
                    'image' => $value->image,
                    'url' => '',
                    'desc' => base64_encode($value->desc),
                    'like' => 0,
                    'view' => 0
                ];
            }
        }  
        $data_reponse = [
            'data' => $data,
            'success' => true,
            'message' => 'ok!',
            'page' => $list_news->currentPage(),
            'totalpage' => $list_news->lastPage()
        ];    
        return response(json_encode($data_reponse))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getDetailNewsApi(Request $request){
        // $validator = Validator::make($request->all(), [
        //     'alias' => 'required|numeric',
        // ], $this->messages);
        // if (!$validator->fails()) {
            $data = array();
            if($request->has('id')){
                $news = News::find($request->input('id'));
            } else{
                $news = News::where('title_alias',$request->input('alias'))->first();
            }
            if(!empty($news)){
                $data = [
                    'id' => $news->news_id,
                    'title' => base64_encode($news->title),
                    'desc' => base64_encode($news->desc),
                    'content' => base64_encode($news->content)
                ];
            }
            $data_reponse = [
                'data' => $data,
                'success' => true,
                'message' => 'ok!'
            ];
            return response(json_encode($data_reponse))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
        // } else{
        //     return $validator->messages();
        // }
    }

    public function getListNewsByBoxApi(Request $request){
        $validator = Validator::make($request->all(), [
            'alias' => 'required',
        ], $this->messages);
        if (!$validator->fails()) { 
            $list_news = $this->news->getNewsByBoxApi($request->input('alias'),null,3);
            $data = array();
            if(!empty($list_news)){
                foreach ($list_news as $key => $value) {
                    $data[] = [
                        'id' => $value->news_id,
                        'title' => base64_encode($value->title),
                        'image' => $value->image,
                        'url' => '',
                        'desc' => base64_encode($value->desc),
                        'like' => 0,
                        'view' => 0
                    ];
                }
            }  
            $data_reponse = [
                'data' => $data,
                'success' => true,
                'message' => 'ok!',
                'page' => $list_news->currentPage(),
                'totalpage' => $list_news->lastPage()
            ];    
            return response(json_encode($data_reponse))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');        
        } else{
            return $validator->messages();
        }   
    }

}