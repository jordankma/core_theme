<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class GroupExamCandidateRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\GroupExamCandidate';
    }

    public function getData($group_exam_id,$start, $length) {
        $result = $this->model::where('group_exam_id',$group_exam_id)->skip((int)$start)->take((int)$length)->get();
//        $result = $this->model::paginate($length);
        return $result;
    }
    public function countAll($group_exam_id){
        return $this->model::where('group_exam_id',$group_exam_id)->count();
    }
}
