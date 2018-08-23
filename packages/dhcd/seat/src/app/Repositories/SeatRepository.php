<?php

namespace Dhcd\Seat\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Seat\Repositories
 */
class SeatRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Seat\App\Models\Seat';
    }

    public function findAll() {
        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_seat.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $result;
    }
}
