<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class GroupExamRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\GroupExam';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
