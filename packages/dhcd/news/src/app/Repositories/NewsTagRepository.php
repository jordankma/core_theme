<?php

namespace Dhcd\News\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
/**
 * Class DemoRepository
 * @package Dhcd\News\Repositories
 */
class NewsTagRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\News\App\Models\NewsTag';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_news_tag.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}