<?php

namespace Dhcd\News\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
use Dhcd\News\App\Models\News;
/**
 * Class DemoRepository
 * @package Dhcd\News\Repositories
 */
class NewsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\News\App\Models\News';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_news.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
    public static function getListNews($params) {
        DB::statement(DB::raw('set @rownum=0'));
        $q = News::orderBy('news_id', 'desc')->where('type_page','news');
        if (!empty($params['name']) && $params['name'] != null) {
            $q->where('title', 'like', '%' . $params['name'] . '%');
        }
        if (!empty($params['news_time']) && $params['news_time'] != null) {
            $fromDate = date($params['news_time'] . ' 00:00:00', time());
            $toDate = date($params['news_time'] . ' 23:59:59', time());
            $q->whereBetween('created_at', array($fromDate, $toDate));
        }
        if (!empty($params['is_hot']) && $params['is_hot'] != null) {
            $q->where('is_hot', $params['is_hot']);
        }
        if (!empty($params['news_cat']) && $params['news_cat'] != null) {
            $q->with('getCats')
            ->whereHas('getCats', function ($query) use ($params) {
                $query->where('dhcd_news_cat.news_cat_id', $params['news_cat']);
            });
        }
        $data = $q->select('dhcd_news.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->get(); 
        return $data;
    }

    public static function getListNewsApi($params) {
        $q = News::orderBy('news_id', 'desc');
        if (!empty($params['keyword']) && $params['keyword'] != null) {
            $q->where('title', 'like', '%' . $params['keyword'] . '%');
        }
        if (!empty($params['news_cat_id']) && $params['news_cat_id'] != null) {
            $q->with('getCats')
            ->whereHas('getCats', function ($query) use ($params) {
                $query->whereIn('dhcd_news_cat.news_cat_id', $params['news_cat_id']);
            });
        }
        if (!empty($params['news_tag_id']) && $params['news_tag_id'] != null) {
            $q->with('getTags')
            ->whereHas('getTags', function ($query) use ($params) {
                $query->whereIn('dhcd_news_tag.news_tag_id', $params['news_tag_id']);
            });
        }
        $data = $q->paginate(10); 
        return $data;
    }
}