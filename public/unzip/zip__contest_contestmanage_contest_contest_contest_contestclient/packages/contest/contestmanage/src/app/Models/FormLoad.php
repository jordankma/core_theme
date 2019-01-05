<?php

namespace Contest\Contestmanage\App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class FormLoad extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'form_load';
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
