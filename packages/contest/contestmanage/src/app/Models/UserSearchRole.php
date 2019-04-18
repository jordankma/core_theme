<?php

namespace Contest\Contestmanage\App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserSearchRole extends Eloquent {

    protected $connection = 'mongodb';
    protected $collection = 'user_search_roles';
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
