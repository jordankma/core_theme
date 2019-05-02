<?php

namespace Contest\Contestmanage\App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ListNextRound extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'contest_next_round_list';
//
//    public function nextID(){
//        $current_id = Counters::find('group_exam_candidate_id');
//        if(!empty($current_id)){
//            $_id = $current_id->seq;
//            $_id = $_id + 1;
//            $current_id->seq = $_id;
//            $current_id->update();
//            $this->_id = $_id;
//        }
//    }
}
