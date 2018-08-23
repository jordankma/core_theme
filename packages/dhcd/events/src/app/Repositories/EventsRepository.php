<?php

namespace Dhcd\Events\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class EventsRepository
 * @package Dhcd\Events\Repositories
 */
class EventsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Events\App\Models\Events';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_events.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'))->get();
        return $result;
    }
}
