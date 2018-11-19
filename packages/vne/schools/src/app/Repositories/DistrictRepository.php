<?php

namespace Vne\Schools\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\District\Repositories
 */
class DistrictRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Schools\App\Models\District';
    }

    public function findAll() {

        $result = $this->model::all();
        return $result;
    }
}
