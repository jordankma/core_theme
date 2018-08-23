<?php

namespace Dhcd\Sessionseat\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
/**
 * Class DemoRepository
 * @package Dhcd\Sessionseat\Repositories
 */
class SessionseatRepository extends Repository
{
    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Sessionseat\App\Models\Sessionseat';
    }

    public function findAll() {
        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_sessionseat.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $result;
    }
}
