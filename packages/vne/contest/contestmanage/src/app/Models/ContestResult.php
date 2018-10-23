<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContestResult extends Eloquent {

//    protected $connection = 'mongodb1';
//    protected $collection = 'user_data';

    protected $connection = 'mongodb';
    protected $collection = 'contest_exam_result';
    public function nextId(){
        $cursor = DB::connection('mongodb')->command(array('eval' => 'getNextId("contest_result_id")'));
        $data = $cursor->toArray();
        $this->_id = (int)$data[0]->retval;
    }
}
