<?php

namespace Dhcd\Topic\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
/**
 * Class DemoRepository
 * @package Dhcd\Topic\Repositories
 */
class ApiTopicRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Topic\App\Models\Topic';
    }

}
