<?php

namespace Vne\Schools\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;


/**
 * Class DemoRepository
 * @package Vne\Managerschools\Repositories
 */
class CatuRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Schools\App\Models\CatUnit';
    }

    public function findAll()
    {
        $result = $this->model::all();
        return $result;
    }
}
