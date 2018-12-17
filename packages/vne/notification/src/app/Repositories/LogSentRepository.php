<?php

namespace Vne\Notification\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Notification\Repositories
 */
class LogSentRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Notification\App\Models\LogSent';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('vne_log_sent.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
