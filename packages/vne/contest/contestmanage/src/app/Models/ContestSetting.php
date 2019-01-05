<?php

namespace Contest\Contestmanage\App\Models;

use Illuminate\Support\Facades\DB;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ContestSetting extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'contest_setting';


}
