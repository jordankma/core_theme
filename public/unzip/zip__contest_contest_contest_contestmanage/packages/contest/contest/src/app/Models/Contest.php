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

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
