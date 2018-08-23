<?php

namespace Dhcd\Banner\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
/**
 * Class DemoRepository
 * @package Dhcd\Banner\Repositories
 */
class PositionRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Banner\App\Models\Position';
    }
    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_banner_position.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
