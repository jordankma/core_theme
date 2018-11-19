<?php

namespace Vne\Schools\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;


/**
 * Class DemoRepository
 * @package Vne\Managerschools\Repositories
 */
class SchoolsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Schools\App\Models\Schools';
    }

    public function findAll($start, $length)
    {
        return  $this->model()::where('_id', '>', $start)->skip(0)->take($length)->get();
//        return  $this->model()::chunk((int)$take , 30000);
    }
}
