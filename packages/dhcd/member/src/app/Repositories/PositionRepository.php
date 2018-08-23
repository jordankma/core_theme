<?php

namespace Dhcd\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Member\Repositories
 */
class PositionRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Member\App\Models\Position';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_position.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
