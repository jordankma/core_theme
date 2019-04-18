<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class RoundConfigRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\RoundConfig';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function findByRound($round){
        $result = $this->model::query()->where('round_id', $round)->get();
        return $result;
    }
}
