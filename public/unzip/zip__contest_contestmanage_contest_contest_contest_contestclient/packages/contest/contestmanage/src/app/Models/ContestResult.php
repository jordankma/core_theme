<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContestResult extends Eloquent {

//    protected $connection = 'mongodb1';
//    protected $collection = 'user_data';

    protected $connection = 'mongodb';
    protected $collection = 'contest_exam_result';
//    protected $collection = 'user_data';
    public function nextId(){
        $current_id = Counters::find('contest_result_id');
        if(!empty($current_id)){
            $_id = $current_id->seq;
            $_id = $_id + 1;
            $current_id->seq = $_id;
            $current_id->update();
            $this->_id = $_id;
        }
    }

    public function candidate()
    {
//        return $this->belongsTo(UserContestInfo::class,'member_id','user_id');
        return $this->belongsTo(UserContestInfo::class,'member_id','member_id');
    }
}
