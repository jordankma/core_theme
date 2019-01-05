<?php

namespace Contest\Contestmanage\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Exam\Exammanage\Repositories
 */
class ContestTopicRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Contestmanage\App\Models\ContestTopic';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
    public function findCurrentTopic($time,$type,$round_id = null){
        if(!empty($round_id)){
            $result = $this->model::where('topic_type',$type)->where('round_id',$round_id)->whereRaw('UNIX_TIMESTAMP(`start_date`) < ?',[$time])->whereRaw('UNIX_TIMESTAMP(`end_date`) > ?',[$time])->orderBy('order','asc')->get();
        }
        else{
            $result = $this->model::where('topic_type',$type)->whereRaw('UNIX_TIMESTAMP(`start_date`) < ?',[$time])->whereRaw('UNIX_TIMESTAMP(`end_date`) > ?',[$time])->orderBy('order','asc')->get();
        }
        return $result;
    }

    public function totalRepeatTime($topic_id){
        $result = $this->model::find($topic_id);
        if($result){
            return $result->exam_repeat_time;
        }
        else{
            return null;
        }
    }

    public function getTopicByOrder($round_id, $order){
        $result = $this->model::where('round_id', (int)$round_id)->where('order', (int)$order)->first();
        return $result;
    }
}
