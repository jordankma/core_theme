<?php

namespace Dhcd\Api\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
//use Dhcd\Api\App\Http\Resources\NewsdetailResource;
//use Dhcd\Api\App\Http\Resources\NewsHomeResource;
//use Dhcd\Api\App\Http\Resources\NewsResource;
use Dhcd\News\App\Models\News;
use Validator;
use Cache;
use Crypt;

class NewsController extends BaseController
{
    public function listNewsCate()
    {
        $listCate = app('Dhcd\News\App\Http\Controllers\NewsCatController')->getCateApi();
        return $listCate;
    }

    public function listDocCate()
    {
        $listCate = app('Dhcd\Document\App\Http\Controllers\DocumentCateController')->getCateApi();
        return $listCate;
    }

    public function getNews(Request $request)
    {
        $page = $request->input('page', 1);
        $current_day = date('Y-m-d');
        Cache::forget('api_news_home_page_' . $page);
        if (Cache::has('api_news_home_page_' . $page)) {
            $newsHome = Cache::get('api_news_home_page_' . $page);
        } else {
            $newsHome = News::paginate(10);
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_news_home_page_' . $page, $newsHome, $expiresAt);
        }

        $list_news = [];
        if (count($newsHome) > 0) {
            foreach ($newsHome as $news) {
                $item = new \stdClass();

                $sub_title = $news->getCats[0]->name . ' ' . date_format($news->getCats[0]->created_at, 'd-m-Y');
                $item->id = $news->news_id;
                $item->title = base64_encode($news->title);
                $item->sub_title = base64_encode($sub_title);
                $item->describe = base64_encode($news->desc);
                $item->photo = (self::is_url($news->image)) ? $news->image : config('app.url') . '/' . $news->image;
                $item->content = base64_encode($news->content);
                $item->date_created = date_format($news->created_at, 'Y-m-d');
                $item->date_modified = date_format($news->updated_at, 'Y-m-d');
                $item->is_top_new = ($news->is_hot == 1) ? true : false;

                $list_news[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_news": '. json_encode($list_news) .',
                        "total_page": ' . $newsHome->lastPage() . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');

//        return (NewsResource::collection($newsHome))->additional(['success' => true, 'message' => 'ok!', 'current_day' => $current_day])->response()->setStatusCode(200)->setCharset('utf-8');
    }

    public function getNewshome(Request $request)
    {
        $page = $request->input('page', 1);
        $current_day = date('Y-m-d');
        Cache::forget('api_news_home_page_' . $page);
        if (Cache::has('api_news_home_page_' . $page)) {
            $newsHome = Cache::get('api_news_home_page_' . $page);
        } else {
            $newsHome = News::orderBy('is_hot')->paginate(10);
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_news_home_page_' . $page, $newsHome, $expiresAt);
        }

        $list_news = [];
        if (count($newsHome) > 0) {
            foreach ($newsHome as $news) {
                $item = new \stdClass();

                $sub_title = $news->getCats[0]->name . ' ' . date_format($news->getCats[0]->created_at, 'd-m-Y');
                $item->id = $news->news_id;
                $item->title = base64_encode($news->title);
                $item->sub_title = base64_encode($sub_title);
                $item->describe = base64_encode($news->desc);
                $item->photo = (self::is_url($news->image)) ? $news->image : config('app.url') . '/' . $news->image;
                $item->content = base64_encode($news->content);
                $item->date_created = date_format($news->created_at, 'Y-m-d');
                $item->date_modified = date_format($news->updated_at, 'Y-m-d');
                $item->is_top_new = ($news->is_hot == 1) ? true : false;

                $list_news[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_news_home": '. json_encode($list_news) .',
                        "total_page": ' . $newsHome->lastPage() . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');

//        return (NewsHomeResource::collection($newsHome))->additional(['success' => true, 'message' => 'ok!', 'current_day' => $current_day])->response()->setStatusCode(200)->setCharset('utf-8');
    }

    public function getNewsdetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {

            $id = $request->input('id');
            Cache::forget('api_news_detail_' . $id);
            if (Cache::has('api_news_detail_' . $id)) {
                $news = Cache::get('api_news_detail_' . $id);
            } else {
                $news = News::find($id);
                if (null != $news) {
                    $expiresAt = now()->addMinutes(3600);
                    Cache::put('api_news_detail_' . $id, $news, $expiresAt);
                }
            }

            $list_news = [];
            if (null != $news) {
                $item = new \stdClass();

                $sub_title = $news->getCats[0]->name . ' ' . date_format($news->getCats[0]->created_at, 'd-m-Y');
                $item->id = $news->news_id;
                $item->title = base64_encode($news->title);
                $item->sub_title = base64_encode($sub_title);
                $item->describe = base64_encode($news->desc);
                $item->photo = (self::is_url($news->image)) ? $news->image : config('app.url') . '/' . $news->image;
                $item->content = base64_encode($news->content);
                $item->date_created = date_format($news->created_at, 'Y-m-d');
                $item->date_modified = date_format($news->updated_at, 'Y-m-d');
                $item->is_top_new = ($news->is_hot == 1) ? true : false;

                $list_news[] = $item;
            }

            $data = '{
                    "data": {
                        "list_news_home": '. json_encode($list_news) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');

//            return (NewsdetailResource::collection($newsDetail))->additional(['success' => true, 'message' => 'ok!'])->response()->setStatusCode(200)->setCharset('utf-8');
        } else {
            return $validator->messages();
        }
    }

    function is_url($uri){
        if(preg_match( '/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}'.'((:[0-9]{1,5})?\\/.*)?$/i' ,$uri)){
            return $uri;
        }
        else{
            return false;
        }
    }
}