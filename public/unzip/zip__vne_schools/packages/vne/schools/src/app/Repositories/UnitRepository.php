<?php

namespace Vne\Schools\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;


/**
 * Class DemoRepository
 * @package Vne\Managerschools\Repositories
 */
class UnitRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Schools\App\Models\Unit';
    }

    public function findAll($start, $length)
    {
        return  $this->model()::where('_id', '>', $start)->skip(0)->take($length)->get();
    }

}
