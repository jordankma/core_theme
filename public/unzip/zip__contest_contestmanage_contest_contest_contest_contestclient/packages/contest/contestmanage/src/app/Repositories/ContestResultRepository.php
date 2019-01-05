<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class ContestResultRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\ContestResult';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function getTopicPointByCondition($user_id, $topic_id, $point_method){
        $result = null;
        if($point_method == 1){
            $result = $this->model::select(DB::raw('SUM (total_point) as point'))->where('user_id', (int)$user_id)->where('topic_id', (int)$topic_id)->get();
        }
        elseif($point_method == 2){
            $result = $this->model::select(DB::raw('MAX (total_point) as point'))->where('user_id', (int)$user_id)->where('topic_id', (int)$topic_id)->get();
        }
        elseif($point_method == 3){
            $result = $this->model::select(DB::raw('AVG (total_point) as point'))->where('user_id', (int)$user_id)->where('topic_id', (int)$topic_id)->get();
        }
        return $result;
    }

    public function getTopicTotalRepeat($user_id, $topic_id){
        $result = $this->model::where('user_id', (int)$user_id)->where('topic_id', (int)$topic_id)->count();
        return $result;
    }
}
