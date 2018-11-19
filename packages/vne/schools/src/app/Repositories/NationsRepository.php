<?php

namespace Vne\Schools\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Managerschools\Repositories
 */
class NationsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Schools\App\Models\Nations';
    }

    public function findAll()
    {
        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_nations.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $result;
    }
}
