<?php

namespace Contest\Contestmanage\App\Models;

use Contest\Exam\App\Models\ExamData;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class School extends Eloquent {

    protected $connection = 'mongodb_contest';
    protected $collection = 'schools';
    protected $primaryKey = '_id';
    const UPDATED_AT = null;
    public $timestamps = false;

}
