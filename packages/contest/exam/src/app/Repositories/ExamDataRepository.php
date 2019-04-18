<?php

namespace Contest\Exam\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Contest\Exam\Repositories
 */
class ExamDataRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Contest\Exam\App\Models\ExamData';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function getLastExam($user_id){
        $result = $this->model::where('member_id', $user_id)->orderBy('created_at', 'desc')->first();
        return $result;
    }

    public function countRepeatTime($round_id, $topic_id,$user_id){
        $result = $this->model::where('member_id',(int)$user_id)->where('round_id',(int)$round_id)->where('topic_id',(int)$topic_id)->count();
        return $result;
    }

    public function isExist(){
        return ($this->model::count() > 0)?true:false;
    }
}
