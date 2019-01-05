<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContestResultJava extends Eloquent {

//    protected $connection = 'mongodb1';
//    protected $collection = 'user_data';
    protected $connection = 'mongodb';
    protected $collection = 'user_data';

    public function user()
    {
//        return $this->belongsTo(UserContestInfo::class,'_id','user_id');
        return $this->belongsTo(UserContestInfo::class,'member_id','user_id');
    }
}
