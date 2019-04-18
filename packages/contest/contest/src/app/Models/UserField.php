<?php

namespace Contest\Contest\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserField extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_contest';
    protected $table = 'user_fields';

    protected $primaryKey = 'field_id';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}
