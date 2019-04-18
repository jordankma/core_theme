<?php

namespace Contest\Contest\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contest extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_contest';
    protected $table = 'contest_list';

    protected $primaryKey = 'contest_id';

    protected $fillable = ['name','mysql_host','mysql_port','mysql_database','mysql_username','mysql_password','mongodb_host','mongodb_port','mongodb_database','mongodb_username','mongodb_password','contest_tag','url_static'];

    protected $dates = ['deleted_at'];
}
