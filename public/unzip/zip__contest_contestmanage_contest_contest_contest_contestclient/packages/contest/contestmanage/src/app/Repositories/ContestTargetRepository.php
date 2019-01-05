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
        if(!empty($result)){
            return $result;
        }
    }
    public function getProvince() {
        $result = $this->model::first();
        if(!empty($result)){
            return $result->general['province_id'];
        }
    }

    public function getDistrict() {
        $result = $this->model::first();
        if(!empty($result)){
            return $result->general['district_id'];
        }
    }

    public function countAll(){
        return $this->model::count();
    }

    public function getTargetList(){
        $result = $this->model::first();
        return !empty($result->target)?$result->target:null;
    }
}
