<?php

namespace Contest\Contestmanage\App\Models;

use Contest\Exam\App\Models\ExamData;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserContestInfo extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'users_exam_info';
    const UPDATED_AT = null;
    public $timestamps = false;

    public function nextID(){
        $current_id = Counters::find('candidate_id');
        if(!empty($current_id)){
            $_id = $current_id->seq;
            $_id = $_id + 1;
            $current_id->seq = $_id;
            $current_id->update();
            $this->_id = $_id;
        }
    }

    public function examResult()
    {
        return $this->hasMany(ContestResult::class,'member_id','member_id');
    }

    public function examData()
    {
        return $this->hasMany(ExamData::class,'member_id','member_id');
    }

    public function setUpdatedAt($value)
    {
        // Do nothing.
    }

    public function getUpdatedAtColumn()
    {
        //Do-nothing
    }

}
