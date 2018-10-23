<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class ContestTargetRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\ContestTarget';
    }

    public function getTarget() {
        $result = $this->model::first();
        return $result;
    }
    public function countAll(){
        return $this->model::count();
    }

}
