<?php

namespace Dhcd\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Member\Repositories
 */
class GroupRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Member\App\Models\Group';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_group.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
