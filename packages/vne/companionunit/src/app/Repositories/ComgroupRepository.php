<?php

namespace Vne\Companionunit\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Companionunit\Repositories
 */
class ComgroupRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Companionunit\App\Models\Comgroup';
    }

    public function findAll() {
        $result = $this->model::query();
        $result->select('vne_comgroup.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $result;
    }
    public function findOrFail($id) {
        $result = $this->model::findOrFail($id);
        return $result;
    }
}
