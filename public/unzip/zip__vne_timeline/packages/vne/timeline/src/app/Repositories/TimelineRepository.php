<?php

namespace Vne\Timeline\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Vne\Timeline\Repositories
 */
class TimelineRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Vne\Timeline\App\Models\Timeline';
    }

    public function findAll() {
        $result = $this->model::query();
        $result->select('vne_timeline.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));
        return $result;
    }
    public function apidata(){
        $result = $this->model::query();
        $result->select('vne_timeline.');
        return $result;
    }
    public function findOrFail($id) {
        $result = $this->model::findOrFail($id);
        return $result;
    }
}
