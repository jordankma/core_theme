<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class SeasonConfigRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\SeasonConfig';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function findBySeason($season){
        $result = $this->model::query()->where('season_id', $season)->get();
        return $result;
    }
}
