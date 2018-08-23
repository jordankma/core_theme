<?php

namespace Dhcd\Car\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Car\Repositories
 */
class CarRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Car\App\Models\Car';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_car.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $result;
    }
}
