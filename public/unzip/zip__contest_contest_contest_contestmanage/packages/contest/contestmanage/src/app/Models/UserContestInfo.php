<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserContestInfo extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'users_exam_info';
//    public function __construct(){
//        $cursor = DB::connection('mongodb')->command(array('eval' => 'getNextId("candidate_id")'));
//        $data = $cursor->toArray();
//        $this->_id = (int)$data[0]->retval;
//    }
    public function nextID(){
        $cursor = DB::connection('mongodb')->command(array('eval' => 'getNextId("candidate_id")'));
        $data = $cursor->toArray();
        $this->_id = (int)$data[0]->retval;
    }

    public function examResult()
    {
        return $this->hasMany(ContestResult::class,'user_id','member_id');
    }

}
