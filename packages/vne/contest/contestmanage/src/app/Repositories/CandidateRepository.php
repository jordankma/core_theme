<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class CandidateRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\UserContestInfo';
    }

    public function getData($start, $length) {
        $result = $this->model::query()->skip((int)$start)->take((int)$length)->get();
//        $result = $this->model::paginate($length);
        return $result;
    }
    public function countAll(){
        return $this->model::count();
    }

    public function getListData($list,$start, $length){
        $result = $this->model::whereNotIn('member_id', $list)->skip((int)$start)->take((int)$length)->get();
//        $result = $this->model::paginate($length);
        return $result;
    }

    public function countData($list){
        return $this->model::whereNotIn('member_id', $list)->count();
    }
}
