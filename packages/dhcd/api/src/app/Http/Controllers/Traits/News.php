<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\News\App\Models\News as NewsModel;
use Validator;
use Cache;

trait News
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function getNews($request)
    {
        $total_page = 0;
        $page = $request->input('page', 1);
        Cache::forget('api_news_home_page_' . $page);
        if (Cache::has('api_news_home_page_' . $page)) {
            $newsHome = Cache::get('api_news_home_page_' . $page);
        } else {
            $newsHome = NewsModel::paginate(10);
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_news_home_page_' . $page, $newsHome, $expiresAt);
        }

        $list_news = [];
        if (count($newsHome) > 0) {
            foreach ($newsHome as $news) {
                $item = new \stdClass();

                $sub_title = '';
                if (isset($news->getCats) && count($news->getCats) > 0)
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
            $total_page = $newsHome->lastPage();
        }

        $data = '{
                    "data": {
                        "list_news": '. json_encode($list_news) .',
                        "total_page": ' . $total_page . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getNewshome($request)
    {
        $page = $request->input('page', 1);
        Cache::forget('api_news_home_page_' . $page);
        if (Cache::has('api_news_home_page_' . $page)) {
            $newsHome = Cache::get('api_news_home_page_' . $page);
        } else {
            $newsHome = NewsModel::orderBy('is_hot')->paginate(10);
            $expiresAt = now()->addMinutes(3600);
            Cache::put('api_news_home_page_' . $page, $newsHome, $expiresAt);
        }

        $total_page = 0;
        $list_news = [];
        if (count($newsHome) > 0) {
            foreach ($newsHome as $news) {
                $item = new \stdClass();

                $sub_title = '';
                if (isset($news->getCats) && count($news->getCats) > 0)
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
            $total_page = $newsHome->lastPage();
        }

        $data = '{
                    "data": {
                        "list_news_home": '. json_encode($list_news) .',
                        "total_page": ' . $total_page . ',
                        "current_page": '. $page .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getNewsdetail($request)
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
                $news = NewsModel::find($id);
                if (null != $news) {
                    $expiresAt = now()->addMinutes(3600);
                    Cache::put('api_news_detail_' . $id, $news, $expiresAt);
                }
            }

            $item = new \stdClass();
            if (null != $news) {
                $sub_title = '';
                if (isset($news->getCats) && count($news->getCats) > 0)
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
            }

            $data = '{
                    "data": '. json_encode($item) .',
                    "success" : true,
                    "message" : "ok!"
                }';
            $data = str_replace('null', '""', $data);
            return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
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