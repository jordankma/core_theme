<?php

namespace Dhcd\Notification\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Notification\Repositories
 */
class NotificationRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Notification\App\Models\Notification';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_notification.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
