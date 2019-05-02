<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class UserNextRoundRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\UserNextRound';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
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

    public function getListBySchool($school_id, $classgroup = 0, $class_id = 0){
        $result = $this->model::query()->where('school_id', (int)$school_id);
        if($classgroup != 0){
            $result = $result->where('target',(string)$classgroup);
        }
        if($class_id != 0){
            $result = $result->where('class_id',(int)$class_id);
        }
        return $result;
    }

}
