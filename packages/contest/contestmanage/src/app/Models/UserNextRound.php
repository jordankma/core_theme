<?php

namespace Contest\Contestmanage\App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserNextRound extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'users_next_round_info';
    const UPDATED_AT = null;
    public $timestamps = false;

    public function setUpdatedAt($value)
    {
        // Do nothing.
    }

    public function getUpdatedAtColumn()
    {
        //Do-nothing
    }

}
