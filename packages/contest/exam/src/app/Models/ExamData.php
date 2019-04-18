<?php

namespace Contest\Exam\App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ExamData extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'contest_exam_data';

}
