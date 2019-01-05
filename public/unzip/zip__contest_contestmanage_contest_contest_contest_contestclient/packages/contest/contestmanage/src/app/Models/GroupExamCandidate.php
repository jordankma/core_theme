<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class GroupExamCandidate extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'group_exam_has_candidates';
//    public function __construct(){
//        $cursor = DB::connection('mongodb')->command(array('eval' => 'getNextId("group_exam_candidate_id")'));
//        $data = $cursor->toArray();
//        $this->_id = (int)$data[0]->retval;
//    }
    public function nextID(){
        $current_id = Counters::find('group_exam_candidate_id');
        if(!empty($current_id)){
            $_id = $current_id->seq;
            $_id = $_id + 1;
            $current_id->seq = $_id;
            $current_id->update();
            $this->_id = $_id;
        }
    }

    public function member(){
        return $this->belongsTo(UserContestInfo::class,'member_id','member_id');
    }

}
