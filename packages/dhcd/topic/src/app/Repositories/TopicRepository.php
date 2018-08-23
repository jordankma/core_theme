<?php

namespace Dhcd\Topic\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
/**
 * Class DemoRepository
 * @package Dhcd\Topic\Repositories
 */
class TopicRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Topic\App\Models\Topic';
    }

    public function deleteID($id) {
        return $this->model->where('topic_id', '=', $id)->update(['visible' => 0]);
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_topic.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
